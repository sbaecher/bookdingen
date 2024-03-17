<?php

require_once __DIR__ . '/src/Api/sessionValidation.php';
include_once __DIR__ . '/src/Repository/UserRepository.php';

$userRepository = new UserRepository();

$currentUser = $userRepository->getById($_SESSION['user_id']);

if (!$currentUser->isAdmin()) {
    header('Location: index.php');
    exit();
}

$editUser = $userRepository->getById(htmlspecialchars($_GET['id']));

$success = '';

$selectUserRole = 'selected';
$selectAdminRole = '';

if ($editUser->isAdmin()) {
    $selectUserRole = '';
    $selectAdminRole = 'selected';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $editUser->setUserName($_POST['userName']);
    $editUser->setEmail($_POST['email']);
    $editUser->setFullName($_POST['fullName']);
    $editUser->setRole($_POST['role']);

    if (!empty($_POST['password'])) {
        $editUser->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
    }

    $userRepository->update($editUser);

    $success = 'Erfolgreich bearbeitet!';
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheksverwaltung - Einstellungen</title>
    <link rel="stylesheet" href="public/css/settings.css">
    <link rel="stylesheet" href="public/css/navigation.css">
</head>
<body>
<div class="container">

    <?php include_once __DIR__ . '/public/template/navigation.php'; ?>

    <div class="content">
        <div class="settings-container">
            <h1>Einstellungen</h1>
            <form action="#" method="post">
                <?php
                    if (isset($success)) {
                        echo '<p class="success">' . $success . '</p>';
                    }
                ?>
                <div class="form-group">
                    <label for="fullname">Vollständiger Name:</label>
                    <input type="text" id="fullName" name="fullName" value="<?= $editUser->getFullName() ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Benutzername:</label>
                    <input type="text" id="username" name="userName" value="<?= $editUser->getUserName() ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-Mail-Adresse:</label>
                    <input type="email" id="email" name="email" value="<?= $editUser->getEmail() ?>" required>
                </div>
                <div class="form-group">
                    <label for="role">Rolle:</label>
                    <select id="role" name="role" required>
                        <option value="user" <?= $selectUserRole ?>>User</option>
                        <option value="admin" <?= $selectAdminRole ?>>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Neues Passwort:</label>
                    <input type="password" id="password" name="password" >
                </div>
                <button type="submit">Speichern</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
