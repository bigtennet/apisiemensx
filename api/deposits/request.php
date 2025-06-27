<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    send_json(['error' => 'Invalid JSON'], 400);
}

$amount = $input['amount'] ?? 0;
$method = $input['method'] ?? '';
if ($amount <= 0 || !$method) {
    send_json(['error' => 'Invalid payload'], 400);
}

$stmt = $pdo->prepare('INSERT INTO deposits (user_id, amount, method, status) VALUES (?, ?, ?, "pending")');
$stmt->execute([$user['id'], $amount, $method]);

send_json(['message' => 'Deposit requested']);
?>
