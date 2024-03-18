<?php

include_once 'UserRepositoryTest.php';
include_once 'MediaRepositoryTest.php';
include_once 'BorrowedRepositoryTest.php';

echo '===== Start Testing =====' . "\n";

$userRepositoryTest = new UserRepositoryTest();

if ($userRepositoryTest->startTests()) {
    echo 'Test: UserRepositoryTest erfolgreich!' . "\n";
} else {
    die('Test: UserRepositoryTest fehlgeschlagen!' . "\n");
}
/*
$mediaRepositoryTest = new MediaRepositoryTest();

if ($mediaRepositoryTest->startTests()) {
    echo 'Test: MediaRepositoryTest erfolgreich!' . "\n";
} else {
    die('Test: MediaRepositoryTest fehlgeschlagen!' . "\n");
}

$borrowedRepositoryTest = new BorrowedRepositoryTest();

if ($mediaRepositoryTest->startTests()) {
    echo 'Test: BorrowedRepositoryTest erfolgreich!' . "\n";
} else {
    die('Test: BorrowedRepositoryTest fehlgeschlagen!' . "\n");
}
*/
echo '===== Testing Erfolgreich =====' . "\n";
