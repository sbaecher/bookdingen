<?php

if (
    !isset($_GET['media_id'])
    || !isset($_GET['user_id'])
) {
    header('Location: index.php');
    exit();
}

include_once __DIR__ . '/../Repository/BorrowedRepository.php';
include_once __DIR__ . '/../Entity/Borrowed.php';

$borrowedRepository = new BorrowedRepository();

$borrowed = new Borrowed();
$borrowed->setTimestamp(time());
$borrowed->setUserId($_GET['user_id']);
$borrowed->setMediaId($_GET['media_id']);

$borrowedRepository->create($borrowed);
