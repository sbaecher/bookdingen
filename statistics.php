<?php

require_once __DIR__ . '/src/Api/sessionValidation.php';

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
                        <p>Gesamtanzahl der Ausleihvorgänge: 100</p>
                        <p>Durchschnittliche Ausleihdauer: 7 Tage</p>
                    </div>
                    <div class="statistics-item">
                        <h2>Beliebte Medien</h2>
                        <ul>
                            <li>Medium 1: 20 Ausleihen</li>
                            <li>Medium 2: 15 Ausleihen</li>
                            <li>Medium 3: 12 Ausleihen</li>
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
                        data: [12, 30, 3, 5, 2, 3, 34, 5 ,6, 7,8 ,9,9],
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
