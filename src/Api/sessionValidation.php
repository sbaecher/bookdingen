<?php

session_start();

function validateSession(): bool
{
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['signature'])) {
        return false;
    }

    $expectedSignature = hash('sha256', $_SESSION['user_id'] . '9d884496184624f47070271629615bbff863de850c97002928d6c35d08c8a95d');

    if ($_SESSION['signature'] !== $expectedSignature) {
        session_destroy();
        session_start();

        return false;
    }

    return true;
}

if (!validateSession()) {
    header('Location: login.php');
    exit();
}
