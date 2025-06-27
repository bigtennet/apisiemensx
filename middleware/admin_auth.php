<?php
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../helpers/response.php';
require_once __DIR__ . '/../helpers/token.php';

$admin = auth_admin();
if (!$admin) {
    send_json(['error' => 'Unauthorized'], 401);
}
?>
