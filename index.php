<?php
// Simple PHP REST API

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $uri);

// Data file
$dataFile = __DIR__ . '/data/items.json';
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}
$items = json_decode(file_get_contents($dataFile), true);
if (!is_array($items)) {
    $items = [];
}

function sendJson($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

// Routing
if ($segments[0] === '' || $segments[0] === 'index.php') {
    sendJson(['message' => 'API is running']);
}

if ($segments[0] !== 'items') {
    sendJson(['error' => 'Not Found'], 404);
}

$id = $segments[1] ?? null;

switch ($method) {
    case 'GET':
        if ($id === null) {
            sendJson($items);
        }
        foreach ($items as $item) {
            if ($item['id'] == $id) {
                sendJson($item);
            }
        }
        sendJson(['error' => 'Item not found'], 404);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['name'])) {
            sendJson(['error' => 'Invalid payload'], 400);
        }
        $newId = count($items) ? max(array_column($items, 'id')) + 1 : 1;
        $item = ['id' => $newId, 'name' => $input['name']];
        $items[] = $item;
        file_put_contents($dataFile, json_encode($items, JSON_PRETTY_PRINT));
        sendJson($item, 201);
        break;

    case 'PUT':
        if ($id === null) {
            sendJson(['error' => 'Missing ID'], 400);
        }
        $input = json_decode(file_get_contents('php://input'), true);
        foreach ($items as &$item) {
            if ($item['id'] == $id) {
                $item['name'] = $input['name'] ?? $item['name'];
                file_put_contents($dataFile, json_encode($items, JSON_PRETTY_PRINT));
                sendJson($item);
            }
        }
        sendJson(['error' => 'Item not found'], 404);
        break;

    case 'DELETE':
        if ($id === null) {
            sendJson(['error' => 'Missing ID'], 400);
        }
        foreach ($items as $index => $item) {
            if ($item['id'] == $id) {
                array_splice($items, $index, 1);
                file_put_contents($dataFile, json_encode($items, JSON_PRETTY_PRINT));
                sendJson(['message' => 'Deleted']);
            }
        }
        sendJson(['error' => 'Item not found'], 404);
        break;

    default:
        sendJson(['error' => 'Method Not Allowed'], 405);
}
