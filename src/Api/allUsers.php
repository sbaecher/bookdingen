<?php

if (!isset($_GET['auth_code']) || $_GET['auth_code'] != 'MatwMdTOoszgfVyCnTHQ') {
    header('Location: index.php');
    exit();
}

include_once __DIR__ . '/../Repository/UserRepository.php';

$userRepository = new UserRepository();

try {
    $users = $userRepository->all();

    $information = [];

    foreach ($users as $user) {
        $information[] = $user->toArray();
    }

    echo json_encode($information);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Fehler beim Abrufen der Benutzerdaten']);
}
