<?php

require_once __DIR__ . '/src/Api/sessionValidation.php';
include_once __DIR__ . '/src/Repository/UserRepository.php';

function validatePassword($password) {
    $minLength = 8;
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-_+=])[A-Za-z\d!@#$%^&*()-_+=]{8,}$/';

    if (strlen($password) < $minLength) {
        return 'Das Passwort muss mindestens ' . $minLength . ' Zeichen lang sein.';
    } elseif (!preg_match($pattern, $password)) {
        return 'Das Passwort muss mindestens einen Kleinbuchstaben, einen Großbuchstaben, eine Zahl und ein Sonderzeichen enthalten.';
    }

    return true;
}

$userRepository = new UserRepository();

$currentUser = $userRepository->getById($_SESSION['user_id']);

$success = '';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentUser->setUserName($_POST['userName']);
    $currentUser->setEmail($_POST['email']);
    $currentUser->setFullName($_POST['fullName']);

    if (!empty($_POST['password'])) {
        $passwordValidation = validatePassword($_POST['password']);

        if (!empty($passwordValidation)) {
            $error = $passwordValidation;
        } else {
            $currentUser->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
        }
    }

    if (empty($error)) {
        $userRepository->update($currentUser);

        $success = 'Erfolgreich bearbeitet!';
    }
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
                <form action="#" method="POST">
                    <?php
                        if (isset($success)) {
                            echo '<p class="success">' . $success . '</p>';
                        }
                    ?>
                    <?php
                    if (isset($error)) {
                        echo '<p class="error">' . $error . '</p>';
                    }
                    ?>
                    <div class="form-group">
                        <label for="fullname">Vollständiger Name:</label>
                        <input type="text" id="fullName" name="fullName" value="<?= $currentUser->getFullName() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Benutzername:</label>
                        <input type="text" id="username" name="userName" value="<?= $currentUser->getUserName() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail-Adresse:</label>
                        <input type="email" id="email" name="email" value="<?= $currentUser->getEmail() ?>" required>
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
