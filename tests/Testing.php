<?php

include_once 'UserRepositoryTest.php';

echo '===== Start Testing =====' . "\n";

$userRepositoryTest = new UserRepositoryTest();

if ($userRepositoryTest->startTests()) {
    echo 'Test: UserRepositoryTest erfolgreich!' . "\n";
} else {
    die('Test: UserRepositoryTest fehlgeschlagen!' . "\n");
}

echo '===== Testing Erfolgreich =====' . "\n";
