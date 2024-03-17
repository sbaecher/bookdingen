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

$borrowed = $borrowedRepository->getByMediaId($_GET['media_id']);

$borrowedRepository->delete($borrowed->getId());
