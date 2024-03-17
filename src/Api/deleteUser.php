<?php

if (
    !isset($_GET['auth_code'])
    || !isset($_GET['id'])
    || $_GET['auth_code'] != 'MatwMdTOoszgfVyCnTHQ'
) {
    header('Location: index.php');
    exit();
}

include_once __DIR__ . '/../Repository/UserRepository.php';

$userRepository = new UserRepository();

try {
    $deleteUser = $userRepository->delete(htmlspecialchars($_GET['id']));

    echo json_encode(['success' => $deleteUser]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Fehler beim Abrufen der Benutzerdaten']);
}
