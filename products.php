<?php
$title='المتجر'; require 'header.php';
$products=read_json('products.json',[]); $q=trim($_GET['q']??''); $cat=trim($_GET['cat']??'');
$cats=read_json('categories.json',[]);
$products=array_filter($products,function($p)use($q,$cat){if(empty($p['active']))return false;if($cat&&($p['category_id']??'')!==$cat)return false;return !$q||stripos(($p['name'].' '.$p['description']),$q)!==false;});
?>
<h1>🛍️ المتجر</h1>
<form class="form" method="get"><input name="q" value="<?=e($q)?>" placeholder="ابحث عن منتج..."><select name="cat"><option value="">كل الأقسام</option><?php foreach($cats as $c): ?><option value="<?=e($c['id'])?>" <?=$cat===$c['id']?'selected':''?>><?=e($c['name'])?></option><?php endforeach; ?></select><button class="btn">بحث</button></form><br>
<div class="grid"><?php foreach($products as $p): ?><article class="card"><img class="product-img" src="<?=e($p['image']??'')?>" onerror="this.style.display='none'"><h3><?=e($p['name'])?></h3><p><?=e($p['description']??'')?></p><div class="price"><?=money((float)$p['price'])?></div><p class="muted">المتوفر: <?=e((string)($p['stock']??0))?></p><a class="btn" href="product.php?id=<?=e($p['id'])?>">عرض المنتج</a></article><?php endforeach; ?></div>
<?php require 'footer.php'; ?>