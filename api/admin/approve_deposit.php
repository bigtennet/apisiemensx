<?php
require_once __DIR__ . '/../../middleware/admin_auth.php';
require_once __DIR__ . '/../../config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$deposit_id = $input['id'] ?? 0;
$status = $input['status'] ?? '';
if (!$deposit_id || !in_array($status, ['approved','rejected'])) {
    send_json(['error' => 'Invalid payload'], 400);
}

$stmt = $pdo->prepare('UPDATE deposits SET status=? WHERE id=?');
$stmt->execute([$status, $deposit_id]);

send_json(['message' => 'Deposit updated']);
?>
