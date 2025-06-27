<?php
require_once __DIR__ . '/../../middleware/admin_auth.php';
require_once __DIR__ . '/../../config/db.php';

$users = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$pending_deposits = $pdo->query("SELECT COUNT(*) FROM deposits WHERE status='pending'")->fetchColumn();
$pending_withdrawals = $pdo->query("SELECT COUNT(*) FROM withdrawals WHERE status='pending'")->fetchColumn();

send_json([
    'users' => (int)$users,
    'pending_deposits' => (int)$pending_deposits,
    'pending_withdrawals' => (int)$pending_withdrawals
]);
?>
