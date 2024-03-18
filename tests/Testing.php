<?php

include_once __DIR__ . '/UserRepositoryTest.php';

echo '===== Start Testing =====' . "\n";

$userRepositoryTest = new UserRepositoryTest();

if ($userRepositoryTest->startTests()) {
    echo 'Test: UserRepositoryTest erfolgreich!' . "\n";
} else {
    die('Test: UserRepositoryTest fehlgeschlagen!' . "\n");
}

echo '===== Testing Erfolgreich =====' . "\n";
