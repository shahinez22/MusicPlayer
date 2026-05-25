<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

session_start();

$favs = $_SESSION['favs'] ?? [];
if (!is_array($favs)) {
    $favs = [];
}

$indices = array_map(fn($k) => (int)$k, array_keys($favs));

echo json_encode(['ok' => true, 'favs' => $indices]);

