<?php
$title='الرئيسية';
require 'header.php';
$products=read_json('products.json',[]);
$featured=array_values(array_filter($products,fn($p)=>!empty($p['featured']) && !empty($p['active'])));
if(!$featured)$featured=array_values(array_filter($products,fn($p)=>!empty($p['active'])));
$featured=array_slice($featured,0,8);
?>
<section class="hero"><h1>🎮 <?=e(APP_NAME)?></h1><p>متجر متخصص في PlayStation وXbox — صيانة، تعديل، أجهزة، ألعاب وملحقات.</p><a class="btn" href="products.php">تصفح المتجر</a> <a class="btn secondary" href="maintenance.php">اطلب صيانة</a></section>
<h2>منتجات مميزة</h2>
<div class="grid"><?php foreach($featured as $p): ?><article class="card">
<img class="product-img" src="<?=e($p['image']??'')?>" onerror="this.style.display='none'">
<h3><?=e($p['name'])?></h3><p class="muted"><?=e($p['description']??'')?></p><div class="price"><?=money((float)$p['price'])?></div><a class="btn" href="product.php?id=<?=e($p['id'])?>">التفاصيل</a>
</article><?php endforeach; if(!$featured): ?><div class="notice">لم تتم إضافة منتجات بعد. أضفها من لوحة المدير.</div><?php endif; ?></div>
<?php require 'footer.php'; ?>