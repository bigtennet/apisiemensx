<?php
require_once __DIR__ . '/../../middleware/admin_auth.php';
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../helpers/mail.php';

$input = json_decode(file_get_contents('php://input'), true);
$subject = $input['subject'] ?? '';
$message = $input['message'] ?? '';
if (!$subject || !$message) {
    send_json(['error' => 'Invalid payload'], 400);
}

$users = $pdo->query('SELECT email FROM users')->fetchAll();
$emails = [];
foreach ($users as $u) {
    send_email($u['email'], $subject, $message);
    $emails[] = $u['email'];
}

$stmt = $pdo->prepare('INSERT INTO email_broadcasts (admin_id, subject, message, sent_to) VALUES (?, ?, ?, ?)');
$stmt->execute([$admin['id'], $subject, $message, implode(',', $emails)]);

send_json(['message' => 'Emails sent']);
?>
