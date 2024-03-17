<?php

require_once __DIR__ . '/src/Api/sessionValidation.php';

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheksverwaltung - Hauptmenü</title>
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/navigation.css">
</head>
<body>
    <div class="container">

        <?php include_once __DIR__ . '/public/template/navigation.php'; ?>

        <div class="content">
            <div class="main-menu-container">
                <h1>Hauptmenü</h1>

                <h2>Bücher</h2>
                <ul id="book-list" class="media-list books"></ul>
        
                <h2>Zeitschriften</h2>
                <ul id="magazines-list" class="media-list magazines"></ul>
        
                <h2>Andere Medien</h2>
                <ul id="other-list" class="media-list other-media"></ul>
            </div>
        </div>
    </div>
</body>
<script>
    let media = [];

    function loadMedia() {
        fetch('/src/Api/allMedia.php?category=book')
            .then(response => response.json())
            .then(data => {
                media = data;

                const bookList = document.querySelector('#book-list');

                bookList.innerHTML = '';

                media.forEach(mediaOne => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <li>
                        <a href="detailPage.php?id=${mediaOne.id}">
                            <h3>${mediaOne.title}</h3>
                            <p><span>ISBN:</span> ${mediaOne.mediaCode}</p>
                        </a>
                    </li>
                    `;

                    bookList.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Fehler beim Abrufen aller Bücher:', error);
            });

        fetch('/src/Api/allMedia.php?category=magazines')
            .then(response => response.json())
            .then(data => {
                media = data;

                const magazinesList = document.querySelector('#magazines-list');

                magazinesList.innerHTML = '';

                media.forEach(mediaOne => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <li>
                        <a href="detailPage.php?id=${mediaOne.id}">
                            <h3>${mediaOne.title}</h3>
                            <p><span>ISSN:</span> ${mediaOne.mediaCode}</p>
                        </a>
                    </li>
                    `;

                    magazinesList.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Fehler beim Abrufen aller Zeitschriften:', error);
            });

        fetch('/src/Api/allMedia.php?category=other')
            .then(response => response.json())
            .then(data => {
                media = data;

                const otherList = document.querySelector('#other-list');

                otherList.innerHTML = '';

                media.forEach(mediaOne => {
                    const tr = document.createElement('tr');

                    tr.innerHTML = `
                        <li>
                        <a href="detailPage.php?id=${mediaOne.id}">
                            <h3>${mediaOne.title}</h3>
                            <p>Weitere Informationen...</p>
                        </a>
                    </li>
                    `;

                    otherList.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Fehler beim Abrufen aller andere Medien:', error);
            });
    }

    loadMedia();
</script>
</html>
