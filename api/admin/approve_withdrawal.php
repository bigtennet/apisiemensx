<?php
require_once __DIR__ . '/../../middleware/admin_auth.php';
require_once __DIR__ . '/../../config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$withdrawal_id = $input['id'] ?? 0;
$status = $input['status'] ?? '';
if (!$withdrawal_id || !in_array($status, ['approved','rejected'])) {
    send_json(['error' => 'Invalid payload'], 400);
}

$stmt = $pdo->prepare('UPDATE withdrawals SET status=?, processed_by=?, processed_at=NOW() WHERE id=?');
$stmt->execute([$status, $admin['id'], $withdrawal_id]);

send_json(['message' => 'Withdrawal updated']);
?>
