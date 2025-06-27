<?php
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../helpers/response.php';
require_once __DIR__ . '/../helpers/token.php';

$user = auth_user();
if (!$user) {
    send_json(['error' => 'Unauthorized'], 401);
}
?>
