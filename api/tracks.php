<?php
declare(strict_types=1);

// Returns track list for the frontend.
// Expected MP3 path: /audio/*.mp3

header('Content-Type: application/json; charset=utf-8');

$audioDir = __DIR__ . '/../audio';
$publicAudioBase = '/audio/';

$tracks = [];

if (is_dir($audioDir)) {
    $files = glob($audioDir . '/*.mp3') ?: [];
    sort($files);

    $i = 0;
    foreach ($files as $file) {
        $basename = pathinfo($file, PATHINFO_FILENAME);

        // Best-effort: name format "Artist - Title" if possible.
        $artist = 'Unknown';
        $title = $basename;
        if (str_contains($basename, ' - ')) {
            [$maybeArtist, $maybeTitle] = explode(' - ', $basename, 2);
            $artist = trim($maybeArtist) !== '' ? trim($maybeArtist) : 'Unknown';
            $title = trim($maybeTitle) !== '' ? trim($maybeTitle) : $basename;
        }

        $tracks[] = [
            'i' => $i++,
            'title' => $title,
            'artist' => $artist,
            'dur' => null, // frontend can compute after metadata
            'src' => $publicAudioBase . rawurlencode(basename($file)),
        ];
    }
}

// Fallback demo list (no audio will play until you add MP3s).
if (count($tracks) === 0) {
    $tracks = [
        ['i' => 0, 'title' => 'Demo Track 1', 'artist' => 'Demo Artist', 'dur' => '0:00', 'src' => '/audio/demo1.mp3'],
        ['i' => 1, 'title' => 'Demo Track 2', 'artist' => 'Demo Artist', 'dur' => '0:00', 'src' => '/audio/demo2.mp3'],
        ['i' => 2, 'title' => 'Demo Track 3', 'artist' => 'Demo Artist', 'dur' => '0:00', 'src' => '/audio/demo3.mp3'],
    ];
}

echo json_encode(['tracks' => $tracks]);

