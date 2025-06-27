<?php
require_once __DIR__ . '/../../config/cors.php';
require_once __DIR__ . '/../../helpers/response.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/token.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    send_json(['error' => 'Invalid JSON'], 400);
}

$username = $input['username'] ?? '';
$password = $input['password'] ?? '';
if (!$username || !$password) {
    send_json(['error' => 'Missing credentials'], 400);
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE username=? OR email=?');
$stmt->execute([$username, $username]);
$user = $stmt->fetch();
if (!$user || !password_verify($password, $user['password'])) {
    send_json(['error' => 'Invalid credentials'], 401);
}

$token = generate_token($user['id']);

send_json(['token' => $token]);
?>
