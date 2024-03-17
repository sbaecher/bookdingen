<?php

if (
    !isset($_GET['media_id'])
) {
    header('Location: index.php');
    exit();
}

include_once __DIR__ . '/../Repository/BorrowedRepository.php';
include_once __DIR__ . '/../Entity/Borrowed.php';

$borrowedRepository = new BorrowedRepository();

$borrowed = $borrowedRepository->getByMediaIdAndActive($_GET['media_id']);
$borrowed->setActive(false);

$borrowedRepository->update($borrowed);
