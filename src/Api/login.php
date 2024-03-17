<?php

include_once __DIR__ . '/../Service/Database.php';
include_once __DIR__ . '/../Repository/UserRepository.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $userRepository = new UserRepository();

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getByEmail($email);

        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
                    $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $user->setPassword($newHashedPassword);
                    $userRepository->update($user);
                }

                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getUserName();
                $_SESSION['signature'] = hash('sha256', $user->getId() . '9d884496184624f47070271629615bbff863de850c97002928d6c35d08c8a95d');

                header("Location: index.php");
                exit();
            } else {
                $error = "Ungültige E-Mail-Adresse oder Passwort.";
            }
        } else {
            $error = 'Ungültige E-Mail-Adresse oder Passwort.';
        }
    } else {
        $error = 'Bitte fülle alle Felder aus.';
    }
}
