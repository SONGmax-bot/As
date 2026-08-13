<?php
require 'config.php'; verify_csrf();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $action=$_POST['action']??'';$id=(string)($_POST['id']??'');
 if($action==='add'){ $p=product_by_id($id); if($p&&$p['active']&&$p['stock']>0){$_SESSION['cart'][$id]=min((int)$p['stock'],((int)($_SESSION['cart'][$id]??0)+(int)($_POST['qty']??1)));flash('تمت إضافة المنتج إلى السلة.');}}
 elseif($action==='remove'){unset($_SESSION['cart'][$id]);}
 elseif($action==='update'){foreach($_POST['qty']??[] as $pid=>$q){$p=product_by_id((string)$pid);if($p)$_SESSION['cart'][$pid]=max(1,min((int)$p['stock'],(int)$q));}}
 redirect('cart.php');
}
$title='السلة'; require 'header.php'; $items=cart_items();
?>
<h1>🛒 سلة المشتريات</h1>
<?php if(!$items): ?><div class="notice">السلة فارغة.</div>
<?php else: ?>
<form method="post"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><input type="hidden" name="action" value="update">
<table class="table"><tr><th>المنتج</th><th>السعر</th><th>الكمية</th><th>الإجمالي</th><th>حذف</th></tr>
<?php foreach($items as $p): ?><tr>
<td><?=e($p['name'])?></td><td><?=money((float)$p['price'])?></td>
<td><input type="number" name="qty[<?=e($p['id'])?>]" value="<?=e((string)$p['_qty'])?>" min="1" max="<?=e((string)$p['stock'])?>"></td>
<td><?=money((float)$p['price']*$p['_qty'])?></td>
<td><button class="btn secondary" type="submit" formaction="cart.php" name="action" value="remove" onclick="this.form.insertAdjacentHTML('beforeend','<input type=&quot;hidden&quot; name=&quot;id&quot; value=&quot;<?=e($p['id'])?>&quot;>')">حذف</button></td>
</tr><?php endforeach; ?></table></form>
<p class="price">الإجمالي: <?=money(cart_total())?></p>
<form method="post" style="display:inline"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><input type="hidden" name="action" value="update"><button class="btn">تحديث السلة</button></form>
<a class="btn" href="checkout.php">إتمام الطلب</a>
<?php endif; ?>
<?php require 'footer.php'; ?>