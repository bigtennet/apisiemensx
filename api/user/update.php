<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    send_json(['error' => 'Invalid JSON'], 400);
}

$full_name = $input['full_name'] ?? $user['full_name'];
$email = $input['email'] ?? $user['email'];

$stmt = $pdo->prepare('UPDATE users SET full_name=?, email=? WHERE id=?');
$stmt->execute([$full_name, $email, $user['id']]);

send_json(['message' => 'Profile updated']);
?>
