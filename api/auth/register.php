<?php
require_once __DIR__ . '/../../config/cors.php';
require_once __DIR__ . '/../../helpers/response.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/token.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    send_json(['error' => 'Invalid JSON'], 400);
}

$full_name = $input['full_name'] ?? '';
$username = $input['username'] ?? '';
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';
$referred_by = $input['referred_by'] ?? null;

if (!$full_name || !$username || !$email || !$password) {
    send_json(['error' => 'Missing fields'], 400);
}

// check unique username/email
$stmt = $pdo->prepare('SELECT id FROM users WHERE username=? OR email=?');
$stmt->execute([$username, $email]);
if ($stmt->fetch()) {
    send_json(['error' => 'User exists'], 409);
}

$hash = password_hash($password, PASSWORD_BCRYPT);
$referral_code = bin2hex(random_bytes(5));

$stmt = $pdo->prepare('INSERT INTO users (full_name, username, email, password, referral_code, referred_by) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->execute([$full_name, $username, $email, $hash, $referral_code, $referred_by]);
$user_id = $pdo->lastInsertId();
$token = generate_token($user_id);

send_json(['token' => $token, 'user_id' => $user_id]);
?>
