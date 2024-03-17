<?php

require_once __DIR__ . '/src/Api/sessionValidation.php';
require_once __DIR__ . '/src/Repository/MediaRepository.php';
require_once __DIR__ . '/src/Service/Database.php';

$mediaRepository = new MediaRepository();

$connection = Database::getConnection();

$allTime = $connection->query('SELECT COUNT(`id`) FROM `borrowed`;')->fetch()[0];

$mostBorrowed = $connection->query(
        'SELECT `media_id`, COUNT(*) AS `borrow_count` FROM `borrowed` GROUP BY `media_id` ORDER BY `borrow_count` DESC LIMIT 3; '
)->fetchAll(PDO::FETCH_ASSOC);


$allMonthEntries = $connection->query(
        'SELECT 
                    MONTH(FROM_UNIXTIME(`timestamp`)) AS month,
                    COUNT(*) AS entry_count
                FROM 
                    borrowed
                WHERE 
                    YEAR(FROM_UNIXTIME(`timestamp`)) = YEAR(CURRENT_DATE)
                GROUP BY 
                    month
                ORDER BY 
                    month;
                '
)->fetchAll(PDO::FETCH_ASSOC);
$diagrammDataArray = [
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0,
    8 => 0,
    9 => 0,
    10 => 0,
    11 => 0,
    12 => 0,
];

foreach ($allMonthEntries as $monthEntry) {
    $diagrammDataArray[$monthEntry['month']] = $monthEntry['entry_count'];
}

$diagrammData = implode(', ', $diagrammDataArray);

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotheksverwaltung - Statistiken</title>
    <link rel="stylesheet" href="public/css/statistics.css">
    <link rel="stylesheet" href="public/css/navigation.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">

        <?php include_once __DIR__ . '/public/template/navigation.php'; ?>

        <div class="content">
            <div class="statistics-container">
                <h1>Statistiken</h1>
        
                <div class="statistics">
                    <div class="statistics-item">
                        <h2>Ausleihvorgänge</h2>
                        <p>Gesamtanzahl der Ausleihvorgänge: <?= $allTime ?></p>
                    </div>
                    <div class="statistics-item">
                        <h2>Beliebte Medien</h2>
                        <ul>
                            <?php
                                foreach ($mostBorrowed as $borrowed) {
                                    $media = $mediaRepository->getById($borrowed['media_id']);

                                    echo '<li>' . $media->getTitle() . ': ' . $borrowed['borrow_count'] . ' Ausleihen</li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
        
                <div class="statistics">
                    <h2>Ausleihverlauf</h2>
                    <canvas id="loanHistoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('loanHistoryChart').getContext('2d');
            var loanHistoryChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        'Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'
                    ],
                    datasets: [{
                        label: 'Anzahl der Ausleihen pro Monat',
                        data: [<?= $diagrammData ?>],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
