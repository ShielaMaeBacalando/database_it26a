<?php
include('./conn/conn.php');

// Fetching total population
$totalPopulationStmt = $conn->prepare("SELECT COUNT(*) as totalPopulation FROM tbl_resident");
$totalPopulationStmt->execute();
$totalPopulationResult = $totalPopulationStmt->fetch(PDO::FETCH_ASSOC);
$totalPopulation = $totalPopulationResult['totalPopulation'];

// Fetching the number of Purok
$numPurokStmt = $conn->prepare("SELECT COUNT(DISTINCT address) as numPurok FROM tbl_resident");
$numPurokStmt->execute();
$numPurokResult = $numPurokStmt->fetch(PDO::FETCH_ASSOC);
$numPurok = $numPurokResult['numPurok'];

// Fetching the most populated Purok
$mostPopulatedPurokStmt = $conn->prepare("SELECT address, COUNT(*) as population FROM tbl_resident GROUP BY address ORDER BY population DESC LIMIT 1");
$mostPopulatedPurokStmt->execute();
$mostPopulatedPurokResult = $mostPopulatedPurokStmt->fetch(PDO::FETCH_ASSOC);
$mostPopulatedPurok = $mostPopulatedPurokResult['address'];

// Fetching the average population
$averagePopulationStmt = $conn->prepare("SELECT AVG(population) as averagePopulation FROM (SELECT COUNT(*) as population FROM tbl_resident GROUP BY address) as subquery");
$averagePopulationStmt->execute();
$averagePopulationResult = $averagePopulationStmt->fetch(PDO::FETCH_ASSOC);
$averagePopulation = number_format($averagePopulationResult['averagePopulation'], 2);

// Fetching resident count for each Purok
$residentCountStmt = $conn->prepare("SELECT address, COUNT(*) as residentCount FROM tbl_resident GROUP BY address");
$residentCountStmt->execute();
$residentCountResult = $residentCountStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for JavaScript
$labels = [];
$data = [];

foreach ($residentCountResult as $row) {
    $labels[] = $row['address'];
    $data[] = (int)$row['residentCount'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Population Monitoring System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: linear-gradient(to left, #BDBBBE 0%, #9D9EA3 100%), radial-gradient(88% 271%, rgba(255, 255, 255, 0.25) 0%, rgba(254, 254, 254, 0.25) 1%, rgba(0, 0, 0, 0.25) 100%), radial-gradient(50% 100%, rgba(255, 255, 255, 0.30) 0%, rgba(0, 0, 0, 0.30) 100%);
            background-blend-mode: normal, lighten, soft-light;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-width: 1500px;
        }

        .main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card {
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .cards-container {
            width: 85%;
            display: flex;
            justify-content: space-between;
            margin: 35px;
        }
        
        .graph-container {
            display: flex;
            justify-content: center;
            background-color: rgb(255, 255, 255);
            padding: 20px;
            width: 85%;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            border-radius: 10px;
        }

        #myChart {
            height: 640px !important;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-4">Barangay Population Monitoring System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/dashboard.php/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/masterlist.php/">Masterlist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/home.php/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/history.php/">History</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/index.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="main">

        <div class="cards-container">
            <div class="card text-center" style="width: 16.5rem;">
                <div class="card-body">
                    <h5 class="card-title">Total Population</h5>
                    <h2 class="card-text"><?= $totalPopulation ?></h2>
                </div>
            </div>
            <div class="card text-center" style="width: 16.5rem;">
                <div class="card-body">
                    <h5 class="card-title">Number of Purok</h5>
                    <h2 class="card-text"><?= $numPurok ?></h2>
                </div>
            </div>
            <div class="card text-center" style="width: 16.5rem;">
                <div class="card-body">
                    <h5 class="card-title">Most Populated Purok</h5>
                    <h2 class="card-text"><?= $mostPopulatedPurok ?></h2>
                </div>
            </div>
            <div class="card text-center" style="width: 16.5rem;">
                <div class="card-body">
                    <h5 class="card-title">Average Population</h5>
                    <h2 class="card-text"><?= $averagePopulation ?></h2>
                </div>
            </div>
        </div>

        <div class="graph-container">
            <canvas id="myChart"></canvas>
        <div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Number of Residents per Purok',
                    data: <?= json_encode($data) ?>,
                    borderWidth: 1,
                    barThickness: 60
                }]
            },
            options: {
                indexAxis: 'y',

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
</body>
</html>