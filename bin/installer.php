<?php

include_once __DIR__ . '/../src/Service/Database.php';

$connection = Database::getConnection();

if (!empty($connection->errorCode())) {
    die('Verbindung zur Datenbank konnte nicht erfolgen! Siehe: ' . $connection->errorCode() . "\n");
}

$usersStatement = 'CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    user_name VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);';

$usersStatement .= 'ALTER TABLE `users` ADD `role` VARCHAR(50) NOT NULL DEFAULT "user" AFTER `password`; ';

$usersStatement .= "INSERT INTO `users` (`id`, `full_name`, `user_name`, `email`, `password`, `role`) VALUES
(2, 'admin', 'Admin', 'admin@sascha-baecher.dev', '$2y$10$upCEELMUFNXipSphYaaNJ.BdpWL1q9a4WyJQ0s.MnHlNRFRWjBxzC', 'user');";

$mediumStatement = 'CREATE TABLE IF NOT EXISTS media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    media_code VARCHAR(50) NOT NULL UNIQUE,
    category VARCHAR(20) NOT NULL,
    description TEXT
);';

$borrowed = 'CREATE TABLE IF NOT EXISTS borrowed (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    media_id INT NOT NULL,
    timestamp INT NOT NULL,
    active BOOLEAN NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (media_id) REFERENCES media(id)
);';

$borrowed .= "ALTER TABLE `borrowed` CHANGE `active` `active` TINYINT(1) NOT NULL DEFAULT '1';";

$errorCode = $connection->exec(implode('', [
    $usersStatement,
    $mediumStatement,
    $borrowed
]));

if ($errorCode == 1) {
    die('SQL Statment konnte nicht erfolgreich ausgeführt werden!' . "\n");
}

die('Installation ist durchgeführt!' . "\n");
