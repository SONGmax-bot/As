<?php require_once __DIR__.'/config.php'; ?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? APP_NAME) ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
<a class="logo" href="index.php">🎮 <?= e(APP_NAME) ?></a>
<nav>
<a href="index.php">الرئيسية</a><a href="products.php">المتجر</a><a href="maintenance.php">الصيانة</a><a href="services.php">التعديل</a>
<?php if(current_user()): ?><a href="orders.php">طلباتي</a><a href="profile.php">حسابي</a><a href="logout.php">خروج</a><?php else: ?><a href="login.php">تسجيل الدخول</a><?php endif; ?>
<a class="cart" href="cart.php">🛒 السلة (<?= cart_count() ?>)</a>
</nav>
</header>
<main class="container">
<?php if($m=flash()): ?><div class="flash"><?=e($m)?></div><?php endif; ?>
