<?php
require_once __DIR__ . '/../../middleware/auth.php';
require_once __DIR__ . '/../../config/db.php';

$stmt = $pdo->prepare('SELECT SUM(amount) AS total FROM referral_earnings WHERE referrer_id=?');
$stmt->execute([$user['id']]);
$total = $stmt->fetchColumn() ?: 0;

send_json(['total_earnings' => $total]);
?>
