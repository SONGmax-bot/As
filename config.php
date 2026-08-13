<?php
declare(strict_types=1);
session_start();
define('APP_NAME', 'Abdelilah Gaming');
define('BASE_PATH', __DIR__);
define('DATA_PATH', BASE_PATH);
define('UPLOAD_PATH', BASE_PATH);
define('CURRENCY', 'جنيه');
date_default_timezone_set('Africa/Khartoum');
require_once BASE_PATH . '/functions.php';
?>