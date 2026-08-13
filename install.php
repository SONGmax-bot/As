<?php
require 'config.php';
if(is_file(DATA_PATH.'/installed.lock')) exit('تم تثبيت المشروع مسبقاً. احذف installed.lock فقط إذا أردت إعادة التثبيت.');
$defaults=[
'users.json'=>[], 'products.json'=>[], 'categories.json'=>[],
'orders.json'=>[], 'maintenance.json'=>[], 'services.json'=>[],
'delivery.json'=>['default_fee'=>0,'free_after'=>0,'zones'=>[]],
'settings.json'=>['store_name'=>'Abdelilah Gaming','phone1'=>'249121990622','phone2'=>'249922497633','whatsapp'=>'249121990622','facebook'=>'https://www.facebook.com/profile.php?id=61591116642575','telegram'=>'@max01222409084','tiktok'=>'https://www.tiktok.com/@s.o.n.g.20','x'=>'https://x.com/bdalalh39456'],
'admins.json'=>[]
];
if($_SERVER['REQUEST_METHOD']==='POST'){
foreach($defaults as $f=>$v) if(!is_file(DATA_PATH.'/'.$f)) write_json($f,$v);
$admins=[['id'=>uid('admin'),'username'=>trim($_POST['username']),'password'=>password_hash($_POST['password'],PASSWORD_DEFAULT)]];
write_json('admins.json',$admins);
file_put_contents(DATA_PATH.'/installed.lock','installed '.date('c'));
$done=true;
}
?>
<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" href="style.css"><title>تثبيت Abdelilah Gaming</title></head><body><main class="container"><div class="form"><h1>🎮 تثبيت Abdelilah Gaming</h1><?php if(!empty($done)):?><div class="notice">تم التثبيت بنجاح. ادخل إلى لوحة المدير.</div><a class="btn" href="admin_login.php">دخول المدير</a><?php else:?><form method="post"><input name="username" placeholder="اسم المدير" required><input type="password" name="password" placeholder="كلمة مرور المدير" minlength="8" required><button class="btn">تثبيت المشروع</button></form><?php endif;?></div></main></body></html>