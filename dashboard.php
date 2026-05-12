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

// Fetching incident stats
 $totalIncidentsStmt = $conn->prepare("SELECT COUNT(*) as totalIncidents FROM tbl_incident");
 $totalIncidentsStmt->execute();
 $totalIncidents = $totalIncidentsStmt->fetch(PDO::FETCH_ASSOC)['totalIncidents'];

 $pendingIncidentsStmt = $conn->prepare("SELECT COUNT(*) as pendingIncidents FROM tbl_incident WHERE status = 'Pending'");
 $pendingIncidentsStmt->execute();
 $pendingIncidents = $pendingIncidentsStmt->fetch(PDO::FETCH_ASSOC)['pendingIncidents'];

 $resolvedIncidentsStmt = $conn->prepare("SELECT COUNT(*) as resolvedIncidents FROM tbl_incident WHERE status = 'Resolved'");
 $resolvedIncidentsStmt->execute();
 $resolvedIncidents = $resolvedIncidentsStmt->fetch(PDO::FETCH_ASSOC)['resolvedIncidents'];

// Fetching incident count by type
 $incidentTypeStmt = $conn->prepare("SELECT incident_type, COUNT(*) as incidentCount FROM tbl_incident GROUP BY incident_type ORDER BY incidentCount DESC");
 $incidentTypeStmt->execute();
 $incidentTypeResult = $incidentTypeStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for JavaScript
 $labels = [];
 $data = [];

foreach ($residentCountResult as $row) {
    $labels[] = $row['address'];
    $data[] = (int)$row['residentCount'];
}

 $incidentLabels = [];
 $incidentData = [];

foreach ($incidentTypeResult as $row) {
    $incidentLabels[] = $row['incident_type'];
    $incidentData[] = (int)$row['incidentCount'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BarangayPMS</title>

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
        }
        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
        }
        .navbar-brand span {
            color: #ffc107;
        }

        .main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }

        .card {
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            height: 100%;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-3px);
        }

        .card .card-title {
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .card .card-text {
            font-size: 1.8rem;
            font-weight: 600;
            color: #222;
        }

        .card-icon {
            font-size: 1.5rem;
            opacity: 0.15;
            position: absolute;
            top: 12px;
            right: 16px;
        }

        .graph-container {
            background-color: rgb(255, 255, 255);
            padding: 20px;
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            border-radius: 10px;
            position: relative;
            height: 400px;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        @media (min-width: 768px) {
            .graph-container {
                height: 500px;
            }
        }

        @media (min-width: 992px) {
            .graph-container {
                height: 640px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-2 ml-md-4" href="about us.php">Barangay<span>PMS</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/dashboard.php/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/masterlist.php">Masterlist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/incidents.php">Incidents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/home.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/history.php">History</a>
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

        <!-- Population Stats Row -->
        <div class="container-fluid" style="max-width: 1500px;">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12 mb-4 mt-4">
                    <div class="card text-center position-relative">
                        <i class="fas fa-users card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Total Population</h5>
                            <h2 class="card-text"><?= $totalPopulation ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4 mt-4">
                    <div class="card text-center position-relative">
                        <i class="fas fa-map-marker-alt card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Number of Purok</h5>
                            <h2 class="card-text"><?= $numPurok ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4 mt-4">
                    <div class="card text-center position-relative">
                        <i class="fas fa-crown card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Most Populated Purok</h5>
                            <h2 class="card-text"><?= $mostPopulatedPurok ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-4 mt-4">
                    <div class="card text-center position-relative">
                        <i class="fas fa-chart-bar card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Average Population</h5>
                            <h2 class="card-text"><?= $averagePopulation ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incident Stats Row -->
        <div class="container-fluid" style="max-width: 1500px;">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card text-center position-relative" style="border-left: 4px solid #343a40;">
                        <i class="fas fa-exclamation-triangle card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Total Incidents</h5>
                            <h2 class="card-text"><?= $totalIncidents ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card text-center position-relative" style="border-left: 4px solid #ffc107;">
                        <i class="fas fa-clock card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Pending Incidents</h5>
                            <h2 class="card-text"><?= $pendingIncidents ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card text-center position-relative" style="border-left: 4px solid #28a745;">
                        <i class="fas fa-check-circle card-icon"></i>
                        <div class="card-body">
                            <h5 class="card-title">Resolved Incidents</h5>
                            <h2 class="card-text"><?= $resolvedIncidents ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Population Graph -->
        <div class="container-fluid" style="max-width: 1500px;">
            <div class="section-title"><i class="fas fa-chart-horizontal-bar mr-1"></i> Population per Purok</div>
            <div class="graph-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <!-- Incident Graph -->
        <?php if (count($incidentTypeResult) > 0): ?>
        <div class="container-fluid mt-4" style="max-width: 1500px;">
            <div class="section-title"><i class="fas fa-exclamation-triangle mr-1"></i> Incidents by Type</div>
            <div class="graph-container" style="height: 300px;">
                <canvas id="incidentChart"></canvas>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        // Population Chart
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Number of Residents per Purok',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: 'rgba(52, 58, 64, 0.8)',
                    borderColor: 'rgba(52, 58, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { autoSkip: true }
                    },
                    x: {
                        ticks: { autoSkip: true }
                    }
                }
            }
        });

        // Incident Chart
        <?php if (count($incidentTypeResult) > 0): ?>
        const ctx2 = document.getElementById('incidentChart');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($incidentLabels) ?>,
                datasets: [{
                    data: <?= json_encode($incidentData) ?>,
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(111, 66, 193, 0.8)',
                        'rgba(0, 123, 255, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(253, 126, 20, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: { family: 'Poppins', size: 12 },
                            padding: 16
                        }
                    }
                }
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>