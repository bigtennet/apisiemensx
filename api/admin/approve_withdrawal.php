<?php
require_once __DIR__ . '/../../middleware/admin_auth.php';
require_once __DIR__ . '/../../config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$withdrawal_id = $input['id'] ?? 0;
$status = $input['status'] ?? '';
if (!$withdrawal_id || !in_array($status, ['approved','rejected'])) {
    send_json(['error' => 'Invalid payload'], 400);
}


$stmt = $pdo->prepare('SELECT user_id, amount, status FROM withdrawals WHERE id=?');
$stmt->execute([$withdrawal_id]);
$withdrawal = $stmt->fetch();
if (!$withdrawal) {
    send_json(['error' => 'Withdrawal not found'], 404);
}

$pdo->beginTransaction();
$stmt = $pdo->prepare('UPDATE withdrawals SET status=?, processed_by=?, processed_at=NOW() WHERE id=?');
$stmt->execute([$status, $admin['id'], $withdrawal_id]);

if ($status === 'approved' && $withdrawal['status'] !== 'approved') {
    $stmt = $pdo->prepare('UPDATE users SET balance = balance - ? WHERE id=?');
    $stmt->execute([$withdrawal['amount'], $withdrawal['user_id']]);
    $stmt = $pdo->prepare('INSERT INTO transactions (action, debit, userId) VALUES ("withdrawal", ?, ?)');
    $stmt->execute([$withdrawal['amount'], $withdrawal['user_id']]);
}

$pdo->commit();

send_json(['message' => 'Withdrawal updated']);
?>
