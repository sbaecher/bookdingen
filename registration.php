<?php

require_once __DIR__ . '/src/Api/registration.php';

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheksverwaltung - Registrierung</title>
    <link rel="stylesheet" href="public/css/registration.css">
    <link rel="stylesheet" href="public/css/navigation.css">
</head>
<body>
    <div class="container">

        <?php include_once __DIR__ . '/public/template/navigation.php'; ?>

        <div class="content">
            <div class="register-container">
                <h1>Registrierung für die Bibliotheksverwaltung</h1>
                <form id="register-form" action="#" method="post">
                    <?php
                        if (isset($error)) {
                            echo '<p class="error">' . $error . '</p>';
                        }
                    ?>
                    <div class="form-group">
                        <label for="fullname">Vollständiger Name:</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail Adresse:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Benutzername:</label>
                        <input type="text" id="userName" name="userName" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Passwort:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Registrieren</button>
                    <div class="registration-link">
                        <p>Du hast ein Account? <a href="login.php">Hier einloggen</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
