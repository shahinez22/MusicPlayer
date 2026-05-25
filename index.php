<?php
declare(strict_types=1);

// NativePHP-style single entry.
// Serves the static player HTML.

$playerHtml = __DIR__ . '/music_player_nativephp.html';
if (!file_exists($playerHtml)) {
    http_response_code(500);
    echo 'Missing music_player_nativephp.html';
    exit;
}

header('Content-Type: text/html; charset=utf-8');
readfile($playerHtml);

