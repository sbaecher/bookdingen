<?php

require_once __DIR__ . '/src/Api/sessionValidation.php';
include_once __DIR__ . '/src/Repository/MediaRepository.php';
include_once __DIR__ . '/src/Repository/UserRepository.php';
include_once __DIR__ . '/src/Repository/BorrowedRepository.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$userRepository = new UserRepository();

$currentUser = $userRepository->getById($_SESSION['user_id']);
$currentMedia = (new MediaRepository())->getById($_GET['id']);
$currentBorrowed = (new BorrowedRepository())->getByMediaIdAndActive($_GET['id']);

$borrowedUser = '';

if (!empty($currentBorrowed)) {
    $borrowedUser = $userRepository->getById($currentBorrowed->getUserId());
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheksverwaltung - Detailseite</title>
    <link rel="stylesheet" href="public/css/detail-page.css">
    <link rel="stylesheet" href="public/css/navigation.css">
</head>
<body>
    <div class="container">

        <?php include_once __DIR__ . '/public/template/navigation.php'; ?>

        <div class="content">
            <div class="media-details-container">
                <h1>Detailseite</h1>
        
                <div class="media-details">
                    <h2><?= $currentMedia->getTitle() ?></h2>
                    <p><strong>Autor:</strong> <?= $currentMedia->getAuthor() ?> </p>
                    <p><strong>Kategorie:</strong> <?= $currentMedia->getCategory() ?> </p>
                    <p><strong>ISBN/ISSN:</strong> <?= $currentMedia->getMediaCode() ?> </p>
                    <p><strong>Beschreibung:</strong> <?= $currentMedia->getDescription() ?> </p>
                </div>
        
                <div class="media-actions">
                    <?php
                        if (!empty($borrowedUser)) {
                            echo '<p>Ausgeliehen von: ' . $borrowedUser->getUserName() . '</p>';
                        } else {
                            echo '<button id="borrow-btn" onclick="borrow(' . $currentUser->getId() . ', ' . $currentMedia->getId() . ')">Ausleihen</button>';
                        }

                        if ($currentBorrowed?->getUserId() == $currentUser->getId()) {
                            echo '<button id="return-btn" onclick="returnBorrow(' . $currentMedia->getId() . ')">Zurückgeben</button>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
console.log('asdasd');

    function borrow(userId, mediaId) {
        fetch(`/src/Api/borrow.php?user_id=${userId}&media_id=${mediaId}`)
            .then(() => {
                location.reload();
            })
            .catch(error => {
                console.error('Ausleihen fehlgeschalgen! ', error);
            });
    }

    function returnBorrow(mediaId) {
        fetch(`/src/Api/returnBorrow.php?media_id=${mediaId}`)
            .then(() => {
                location.reload();
            })
            .catch(error => {
                console.error('Zurückgeben fehlgeschalgen! ', error);
            });
    }
</script>
</html>
