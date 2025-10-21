<?php
require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../config/db.php';

$stmt = $pdo->prepare('SELECT * FROM referral_earnings WHERE referrer_id=? ORDER BY created_at DESC');
$stmt->execute([$user['id']]);
$rows = $stmt->fetchAll();

send_json(['earnings' => $rows]);
?>
