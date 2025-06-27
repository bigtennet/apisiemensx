<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    send_json(['error' => 'Invalid JSON'], 400);
}

$amount = $input['amount'] ?? 0;
$wallet = $input['wallet_address'] ?? '';
$method = $input['method'] ?? '';
if ($amount <= 0 || !$wallet || !$method) {
    send_json(['error' => 'Invalid payload'], 400);
}

$stmt = $pdo->prepare('INSERT INTO withdrawals (user_id, amount, wallet_address, method, status) VALUES (?, ?, ?, ?, "pending")');
$stmt->execute([$user['id'], $amount, $wallet, $method]);

send_json(['message' => 'Withdrawal requested']);
?>
