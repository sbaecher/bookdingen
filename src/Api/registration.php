<?php

include_once __DIR__ . '/../Service/Database.php';
include_once __DIR__ . '/../Repository/UserRepository.php';

session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['fullName'])
        && isset($_POST['userName'])
        && isset($_POST['email'])
        && isset($_POST['password'])
    ) {
        $userRepository = new UserRepository();

        $fullName = $_POST['fullName'];
        $userName = $_POST['userName'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $passwordValidation = validatePassword($password);

        if ($userRepository->getByEmail($email)) {
            $error = 'Bitte melden sie sich mit ihrem Account an!';
        } elseif ($passwordValidation !== true) {
            $error = $passwordValidation;
        } else {
            $newUser = new User();
            $newUser->setFullName($fullName);
            $newUser->setUserName($userName);
            $newUser->setEmail($email);
            $newUser->setPassword(password_hash($password, PASSWORD_DEFAULT));

            if ($userRepository->create($newUser)) {
                $user = $userRepository->getByEmail($email);

                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getUserName();
                $_SESSION['signature'] = hash('sha256', $user->getId() . '9d884496184624f47070271629615bbff863de850c97002928d6c35d08c8a95d');

                header('Location: index.php');

                exit();
            } else {
                $error = 'Fehler bei der Registrierung. Bitte versuche es erneut.';
            }
        }
    } else {
        $error = 'Bitte fülle alle Felder aus.';
    }
}
