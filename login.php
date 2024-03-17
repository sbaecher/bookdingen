<?php

require_once __DIR__ . '/src/Api/login.php';

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheksverwaltung - Login</title>
    <link rel="stylesheet" href="public/css/login.css">
    <link rel="stylesheet" href="public/css/navigation.css">
</head>
<body>
    <div class="container">

        <?php include_once __DIR__ . '/public/template/navigation.php'; ?>

        <div class="content">
            <div class="login-container">
                <h1>Login zur Bibliotheksverwaltung</h1>
                <form id="login-form" action="#" method="post">
                    <?php
                        if (isset($error)) {
                            echo '<p class="error">' . $error . '</p>';
                        }
                    ?>
                    <div class="form-group">
                        <label for="username">Email:</label>
                        <input type="text" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Passwort:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Anmelden</button>
                    <div class="registration-link">
                        <p>Du hast noch keinen Account? <a href="registration.php">Hier registrieren</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
