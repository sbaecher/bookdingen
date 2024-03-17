<?php

include_once __DIR__ . '/../Repository/MediaRepository.php';

$mediaRepository = new MediaRepository();

try {
    $medias = $mediaRepository->all();

    $information = [];

    foreach ($medias as $media) {
        if (isset($_GET['category']) && $media->getCategory() != $_GET['category']) {
            continue;
        }

        $information[] = $media->toArray();
    }

    echo json_encode($information);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Fehler beim Abrufen der Medien']);
}
