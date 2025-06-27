<?php
require_once __DIR__ . '/../../middleware/auth.php';

unset($user['password']);
unset($user['api_token']);

send_json($user);
?>
