<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

session_start();

$raw = file_get_contents('php://input');
$data = [];
if ($raw !== false && $raw !== '') {
    $data = json_decode($raw, true) ?: [];
}

$idx = $data['i'] ?? null;
if (!is_numeric($idx)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Missing/invalid i']);
    exit;
}
$idx = (int)$idx;

if (!isset($_SESSION['favs']) || !is_array($_SESSION['favs'])) {
    $_SESSION['favs'] = [];
}

$favs = $_SESSION['favs'];
$key = (string)$idx;

$liked = false;
if (array_key_exists($key, $favs)) {
    unset($favs[$key]);
    $liked = false;
} else {
    $favs[$key] = true;
    $liked = true;
}

$_SESSION['favs'] = $favs;

echo json_encode(['ok' => true, 'liked' => $liked]);

