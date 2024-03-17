<?php

require_once __DIR__ . '/src/Api/sessionValidation.php';
include_once __DIR__ . '/src/Repository/UserRepository.php';
include_once __DIR__ . '/src/Repository/MediaRepository.php';
include_once __DIR__ . '/src/Entity/Media.php';

$userRepository = new UserRepository();

$currentUser = $userRepository->getById($_SESSION['user_id']);

if (!$currentUser->isAdmin()) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $media = new Media();
    $media->setTitle($_POST['title'] ?? '');
    $media->setAuthor($_POST['author'] ?? '');
    $media->setMediaCode($_POST['isbn_issn'] ?? '');
    $media->setCategory($_POST['category'] ?? '');
    $media->setDescription($_POST['description'] ?? '');

    $mediaRepository = new MediaRepository();
    $mediaRepository->create($media);

    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheksverwaltung - Katalogisierung</title>
    <link rel="stylesheet" href="public/css/catalogization.css">
    <link rel="stylesheet" href="public/css/navigation.css">
</head>
<body>
    <div class="container">

        <?php include_once __DIR__ . '/public/template/navigation.php'; ?>

        <div class="content">
            <div class="catalogue-container">
                <h1>Katalogisierung</h1>
                <form id="catalogue-form" action="#" method="post">
                    <div class="form-group">
                        <label for="title">Titel:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="author">Autor:</label>
                        <input type="text" id="author" name="author" required>
                    </div>
                    <div class="form-group">
                        <label for="isbn_issn">ISBN/ISSN:</label>
                        <input type="text" id="isbn_issn" name="isbn_issn" required>
                        <small>Geben Sie hier entweder die ISBN (für Bücher) oder die ISSN (für Zeitschriften) ein.</small>
                    </div>
                    <div class="form-group">
                        <label for="category">Kategorie:</label>
                        <select id="category" name="category" required>
                            <option value="">Bitte wählen</option>
                            <option value="book">Bücher</option>
                            <option value="magazines">Zeitschriften</option>
                            <option value="other">Andere Medien</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Beschreibung:</label>
                        <textarea id="description" name="description" rows="4"></textarea>
                    </div>
                    <button type="submit">Speichern</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
