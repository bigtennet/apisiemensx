<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../config/db.php';

$stmt = $pdo->prepare('SELECT * FROM transactions WHERE userId=? ORDER BY date DESC');
$stmt->execute([$user['id']]);
$rows = $stmt->fetchAll();

send_json(['transactions' => $rows]);
?>
