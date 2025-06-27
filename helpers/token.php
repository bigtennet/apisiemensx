<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/response.php';

function generate_token($user_id, $table = 'users') {
    global $pdo;
    $token = bin2hex(random_bytes(16));
    $stmt = $pdo->prepare("UPDATE {$table} SET api_token=? WHERE id=?");
    $stmt->execute([$token, $user_id]);
    return $token;
}

function auth_user() {
    global $pdo;
    $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/Bearer\s+(.*)$/i', $auth, $m)) {
        $token = $m[1];
        $stmt = $pdo->prepare('SELECT * FROM users WHERE api_token=?');
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        if ($user) {
            return $user;
        }
    }
    return null;
}

function auth_admin() {
    global $pdo;
    $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/Bearer\s+(.*)$/i', $auth, $m)) {
        $token = $m[1];
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE api_token=?');
        $stmt->execute([$token]);
        $admin = $stmt->fetch();
        if ($admin) {
            return $admin;
        }
    }
    return null;
}
?>
