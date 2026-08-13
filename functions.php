<?php
declare(strict_types=1);

function ensure_storage(): void {
    if (!is_dir(DATA_PATH)) @mkdir(DATA_PATH, 0755, true);
}
ensure_storage();

function read_json(string $file, array $default=[]): array {
    $path = DATA_PATH.'/'.$file;
    if (!is_file($path)) { write_json($file, $default); return $default; }
    $data = json_decode((string)file_get_contents($path), true);
    return is_array($data) ? $data : $default;
}
function write_json(string $file, array $data): bool {
    $path = DATA_PATH.'/'.$file;
    return file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT), LOCK_EX) !== false;
}
function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header('Location: '.$url); exit; }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(24));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('طلب غير صالح.');
    }
}
function flash(?string $msg=null): ?string {
    if ($msg !== null) { $_SESSION['flash']=$msg; return null; }
    $m=$_SESSION['flash']??null; unset($_SESSION['flash']); return $m;
}
function current_user(): ?array {
    if (empty($_SESSION['user_id'])) return null;
    foreach(read_json('users.json') as $u) if (($u['id']??'')===$_SESSION['user_id']) return $u;
    return null;
}
function require_login(): void { if (!current_user()) redirect('login.php'); }
function current_admin(): bool { return !empty($_SESSION['admin_id']); }
function require_admin(): void { if (!current_admin()) redirect('admin_login.php'); }
function money(float $n): string { return number_format($n, 0, '.', ',').' '.CURRENCY; }
function setting(string $key, string $default=''): string {
    $s=read_json('settings.json', []);
    return (string)($s[$key] ?? $default);
}
function product_by_id(string $id): ?array {
    foreach(read_json('products.json') as $p) if (($p['id']??'')===$id) return $p;
    return null;
}
function cart_items(): array {
    $cart=$_SESSION['cart']??[]; $out=[];
    foreach($cart as $id=>$qty) {
        $p=product_by_id((string)$id);
        if ($p) { $p['_qty']=max(1,(int)$qty); $out[]=$p; }
    }
    return $out;
}
function cart_total(): float {
    $t=0; foreach(cart_items() as $p) $t += ((float)$p['price'] * $p['_qty']); return $t;
}
function cart_count(): int {
    $n=0; foreach($_SESSION['cart']??[] as $q) $n+=(int)$q; return $n;
}
function uid(string $prefix): string { return $prefix.'_'.bin2hex(random_bytes(6)); }
?>