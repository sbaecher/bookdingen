<?php

include_once __DIR__ . '/../../src/Repository/UserRepository.php';

$navigationUserName = 'Benutzer';
$adminNavigation = '';

$navigationUserRepository = new UserRepository();

$navigationUserID = $_SESSION['user_id'] ?? null;

if (!empty($navigationUserID)) {
    $navigationUser = $navigationUserRepository->getById($navigationUserID);
}

if (isset($navigationUser)) {
    $navigationUserName = $navigationUser->getUserName();

    if ($navigationUser->isAdmin()) {
        $adminNavigation = '<li><a href="catalogization.php">Katalogisierung</a></li>'
            . '<li><a href="userManagement.php">Benutzerverwaltung</a></li>';
    }
}

echo str_replace(
    [
        '%adminNavigation%',
        '%userName%'
    ],
    [
        $adminNavigation,
        $navigationUserName
    ],
    file_get_contents(__DIR__ . '/html/navigation.html')
);
