<?php
require_once __DIR__ . '/../../middleware/admin_auth.php';
require_once __DIR__ . '/../../config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$deposit_id = $input['id'] ?? 0;
$status = $input['status'] ?? '';
if (!$deposit_id || !in_array($status, ['approved','rejected'])) {
    send_json(['error' => 'Invalid payload'], 400);
}


$stmt = $pdo->prepare('SELECT user_id, amount, status FROM deposits WHERE id=?');
$stmt->execute([$deposit_id]);
$deposit = $stmt->fetch();
if (!$deposit) {
    send_json(['error' => 'Deposit not found'], 404);
}

$pdo->beginTransaction();
$stmt = $pdo->prepare('UPDATE deposits SET status=? WHERE id=?');
$stmt->execute([$status, $deposit_id]);

if ($status === 'approved' && $deposit['status'] !== 'approved') {
    $stmt = $pdo->prepare('UPDATE users SET balance = balance + ? WHERE id=?');
    $stmt->execute([$deposit['amount'], $deposit['user_id']]);
    $stmt = $pdo->prepare('INSERT INTO transactions (action, credit, userId) VALUES ("deposit", ?, ?)');
    $stmt->execute([$deposit['amount'], $deposit['user_id']]);
}

$pdo->commit();

send_json(['message' => 'Deposit updated']);
?>
