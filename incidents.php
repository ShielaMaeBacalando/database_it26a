<?php
include('./conn/conn.php');

// Fetch all incidents with resident info
 $stmt = $conn->prepare("
    SELECT i.*, r.full_name, r.address, r.contact_number 
    FROM tbl_incident i 
    LEFT JOIN tbl_resident r ON i.tbl_resident_id = r.tbl_resident_id 
    ORDER BY i.date_reported DESC
");
 $stmt->execute();
 $incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch residents for dropdown
 $resStmt = $conn->prepare("SELECT tbl_resident_id, full_name, address FROM tbl_resident ORDER BY full_name ASC");
 $resStmt->execute();
 $residents = $resStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Population Monitoring System</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Data Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: linear-gradient(to left, #BDBBBE 0%, #9D9EA3 100%), radial-gradient(88% 271%, rgba(255, 255, 255, 0.25) 0%, rgba(254, 254, 254, 0.25) 1%, rgba(0, 0, 0, 0.25) 100%), radial-gradient(50% 100%, rgba(255, 255, 255, 0.30) 0%, rgba(0, 0, 0, 0.30) 100%);
            background-blend-mode: normal, lighten, soft-light;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== NAVBAR ===== */
        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
        }
        .navbar-brand span {
            color: #ffc107;
        }

        /* ===== MAIN ===== */
        .main {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex: 1;
            padding: 24px 16px;
        }

        /* ===== CONTAINER ===== */
        .masterlist-container {
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            padding: 28px;
            width: 100%;
            max-width: 1100px;
            border-radius: 12px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        /* ===== HEADER ===== */
        .masterlist-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .masterlist-header h4 {
            margin: 0;
            font-weight: 600;
            font-size: 1.3rem;
            color: #222;
        }
        .masterlist-header .btn-add {
            font-size: 0.88rem;
            padding: 7px 20px;
            border-radius: 6px;
            font-weight: 500;
            white-space: nowrap;
        }

        .divider {
            border: none;
            border-top: 1px solid #dee2e6;
            margin: 16px 0;
        }

        /* ===== TABLE ===== */
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        table.masterlist-table {
            min-width: 780px;
            width: 100% !important;
        }

        table.masterlist-table thead th {
            text-align: center !important;
            vertical-align: middle;
            font-size: 0.84rem;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            padding: 10px 8px;
            white-space: nowrap;
        }

        table.masterlist-table tbody td,
        table.masterlist-table tbody th {
            text-align: center !important;
            vertical-align: middle;
            font-size: 0.84rem;
            padding: 10px 8px;
            color: #333;
        }

        /* ===== STATUS BADGE ===== */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }
        .status-badge.pending { background: #fff3cd; color: #856404; }
        .status-badge.under-investigation { background: #cce5ff; color: #004085; }
        .status-badge.resolved { background: #d4edda; color: #155724; }
        .status-badge.escalated { background: #f8d7da; color: #721c24; }

        /* ===== TYPE BADGE ===== */
        .type-badge {
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }
        .type-badge.theft { background: #f8d7da; color: #721c24; }
        .type-badge.dispute { background: #fff3cd; color: #856404; }
        .type-badge.vandalism { background: #e2d5f1; color: #6f42c1; }
        .type-badge.noise { background: #cce5ff; color: #004085; }
        .type-badge.accident { background: #f8d7da; color: #c9232e; }
        .type-badge.assault { background: #f8d7da; color: #721c24; }
        .type-badge.trespassing { background: #fff3cd; color: #92400e; }
        .type-badge.other { background: #e2e3e5; color: #383d41; }

        /* ===== ACTION BUTTONS ===== */
        .action-cell {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }
        .action-cell .btn {
            width: 30px;
            height: 30px;
            font-size: 14px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            padding: 0 !important;
            border-radius: 6px;
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .action-cell .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        /* ===== DATATABLES OVERRIDES ===== */
        .dataTables_wrapper {
            padding: 0 !important;
        }
        .dataTables_wrapper .dataTables_length {
            float: left;
            margin-bottom: 14px;
            font-size: 0.82rem;
            padding-top: 0;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin-bottom: 14px;
            font-size: 0.82rem;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 4px 10px;
            margin-left: 6px;
            outline: none;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #343a40;
            box-shadow: 0 0 0 2px rgba(52,58,64,0.12);
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 3px 8px;
            outline: none;
        }
        .dataTables_wrapper .dataTables_info {
            float: left;
            font-size: 0.82rem;
            color: #6c757d;
            padding-top: 14px;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            padding-top: 14px;
        }
        .dataTables_paginate .paginate_button {
            font-size: 0.82rem !important;
            padding: 4px 10px !important;
            border-radius: 4px !important;
            margin: 0 2px !important;
        }
        .dataTables_empty {
            text-align: center !important;
            padding: 40px 0 !important;
            font-size: 0.95rem;
            color: #999;
        }
        table.dataTable thead > tr > th.sorting,
        table.dataTable thead > tr > th.sorting_asc,
        table.dataTable thead > tr > th.sorting_desc,
        table.dataTable thead > tr > th.sorting_asc_disabled,
        table.dataTable thead > tr > th.sorting_desc_disabled {
            text-align: center !important;
        }

        /* ===== MODALS ===== */
        .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding: 16px 20px;
        }
        .modal-header .modal-title {
            font-weight: 600;
            font-size: 1.08rem;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-body .form-group label {
            font-size: 0.88rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
        }
        .modal-body .form-control {
            font-size: 0.9rem;
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 8px 12px;
        }
        .modal-body .form-control:focus {
            border-color: #343a40;
            box-shadow: 0 0 0 2px rgba(52,58,64,0.15);
        }
        .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 12px 20px;
        }
        .modal-footer .btn {
            font-size: 0.88rem;
            padding: 7px 22px;
            border-radius: 6px;
            font-weight: 500;
            min-width: 90px;
        }

        /* ===== VIEW DETAIL ===== */
        .view-detail {
            display: flex;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
        }
        .view-detail:last-child { border-bottom: none; }
        .view-detail .detail-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 130px;
            flex-shrink: 0;
            padding-top: 2px;
        }
        .view-detail .detail-value {
            font-size: 0.88rem;
            color: #333;
            font-weight: 500;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 575.98px) {
            .main { padding: 12px 6px; }
            .masterlist-container { padding: 14px 10px; border-radius: 10px; }
            .masterlist-header { flex-direction: column; align-items: stretch; text-align: center; }
            .masterlist-header h4 { font-size: 1.1rem; }
            .masterlist-header .btn-add { width: 100%; }
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter { float: none !important; text-align: left !important; width: 100%; margin-bottom: 10px; }
            .dataTables_wrapper .dataTables_filter input { width: 100%; margin-left: 0; margin-top: 4px; display: block; }
            .dataTables_wrapper .dataTables_length select { display: inline-block; width: auto; }
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate { float: none !important; text-align: center !important; width: 100%; padding-top: 6px; }
            .modal-dialog { margin: 10px; }
            .modal-footer { flex-wrap: wrap; }
            .modal-footer .btn { flex: 1; }
            .navbar-nav .nav-link { padding: 8px 0 !important; }
        }
        @media (min-width: 576px) and (max-width: 767.98px) {
            .main { padding: 16px 10px; }
            .masterlist-container { padding: 20px 14px; }
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter { float: none !important; text-align: left !important; width: 100%; margin-bottom: 10px; }
            .dataTables_wrapper .dataTables_filter input { width: 70%; }
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate { float: none !important; text-align: center !important; width: 100%; padding-top: 6px; }
        }
        @media (min-width: 768px) and (max-width: 991.98px) {
            .masterlist-container { max-width: 95%; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-lg-4" href="about us.php">Barangay<span>PMS</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/masterlist.php">Masterlist</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/incidents.php">Incidents <span class="sr-only">(current)</span></a>
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
        <div class="masterlist-container">

            <!-- Header -->
            <div class="masterlist-header">
                <h4>Barangay Incidents</h4>
                <button class="btn btn-dark btn-add" data-toggle="modal" data-target="#addIncidentModal">
                    <i class="fa-solid fa-plus mr-1"></i> Add Incident
                </button>
            </div>
            <hr class="divider">

            <!-- Add Incident Modal -->
            <div class="modal fade" id="addIncidentModal" tabindex="-1" aria-labelledby="addIncidentLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addIncidentLabel">Add Incident</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="./endpoint/add-incident.php" method="POST">
                                <div class="form-group">
                                    <label for="addResident">Resident:</label>
                                    <select class="form-control" name="tbl_resident_id" id="addResident" required>
                                        <option value="">-select resident-</option>
                                        <?php foreach ($residents as $r): ?>
                                            <option value="<?= $r['tbl_resident_id'] ?>">
                                                <?= htmlspecialchars($r['full_name'] . ' - ' . $r['address']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="addIncidentType">Incident Type:</label>
                                    <select class="form-control" name="incident_type" id="addIncidentType" required>
                                        <option value="">-select-</option>
                                        <option value="Theft">Theft</option>
                                        <option value="Dispute">Dispute</option>
                                        <option value="Vandalism">Vandalism</option>
                                        <option value="Noise">Noise Complaint</option>
                                        <option value="Accident">Accident</option>
                                        <option value="Assault">Assault</option>
                                        <option value="Trespassing">Trespassing</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="addIncidentDate">Date of Incident:</label>
                                    <input type="date" class="form-control" id="addIncidentDate" name="incident_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="addLocation">Location:</label>
                                    <input type="text" class="form-control" id="addLocation" name="location" placeholder="e.g. Purok 1 Basketball Court" required>
                                </div>
                                <div class="form-group">
                                    <label for="addStatus">Status:</label>
                                    <select class="form-control" name="status" id="addStatus" required>
                                        <option value="Pending">Pending</option>
                                        <option value="Under Investigation">Under Investigation</option>
                                        <option value="Resolved">Resolved</option>
                                        <option value="Escalated">Escalated</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="addDescription">Description:</label>
                                    <textarea class="form-control" id="addDescription" name="description" rows="3" placeholder="Describe the incident..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Incident Modal -->
            <div class="modal fade" id="updateIncidentModal" tabindex="-1" aria-labelledby="updateIncidentLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateIncidentLabel">Update Incident</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="./endpoint/update-incident.php" method="POST">
                                <input type="hidden" class="form-control" id="updateIncidentID" name="tbl_incident_id">

                                <div class="form-group">
                                    <label for="updateResident">Resident:</label>
                                    <select class="form-control" name="tbl_resident_id" id="updateResident" required>
                                        <option value="">-select resident-</option>
                                        <?php foreach ($residents as $r): ?>
                                            <option value="<?= $r['tbl_resident_id'] ?>">
                                                <?= htmlspecialchars($r['full_name'] . ' - ' . $r['address']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="updateIncidentType">Incident Type:</label>
                                    <select class="form-control" name="incident_type" id="updateIncidentType">
                                        <option value="">-select-</option>
                                        <option value="Theft">Theft</option>
                                        <option value="Dispute">Dispute</option>
                                        <option value="Vandalism">Vandalism</option>
                                        <option value="Noise">Noise Complaint</option>
                                        <option value="Accident">Accident</option>
                                        <option value="Assault">Assault</option>
                                        <option value="Trespassing">Trespassing</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="updateIncidentDate">Date of Incident:</label>
                                    <input type="date" class="form-control" id="updateIncidentDate" name="incident_date">
                                </div>
                                <div class="form-group">
                                    <label for="updateLocation">Location:</label>
                                    <input type="text" class="form-control" id="updateLocation" name="location">
                                </div>
                                <div class="form-group">
                                    <label for="updateStatus">Status:</label>
                                    <select class="form-control" name="status" id="updateStatus">
                                        <option value="Pending">Pending</option>
                                        <option value="Under Investigation">Under Investigation</option>
                                        <option value="Resolved">Resolved</option>
                                        <option value="Escalated">Escalated</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="updateDescription">Description:</label>
                                    <textarea class="form-control" id="updateDescription" name="description" rows="3"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Incident Modal -->
            <div class="modal fade" id="viewIncidentModal" tabindex="-1" aria-labelledby="viewIncidentLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewIncidentLabel">Incident Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="viewIncidentContent">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table table-sm masterlist-table">
                    <thead>
                        <tr>
                            <th scope="col">Incident ID</th>
                            <th scope="col">Resident</th>
                            <th scope="col">Incident Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Location</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (count($incidents) > 0) {
                                foreach ($incidents as $row) {
                                    $incidentID = $row['tbl_incident_id'];
                                    $residentName = $row['full_name'] ?? 'Unknown';
                                    $incidentType = $row['incident_type'];
                                    $incidentDate = $row['incident_date'];
                                    $location = $row['location'];
                                    $status = $row['status'];
                                    $description = $row['description'] ?? '';
                                    $dateReported = $row['date_reported'];
                                    $residentAddress = $row['address'] ?? '';
                                    $contactNumber = $row['contact_number'] ?? '';

                                    $typeClass = strtolower(str_replace(' ', '-', $incidentType));
                                    $statusClass = strtolower(str_replace(' ', '-', $status));
                        ?>
                                    <tr>
                                        <th id="incidentID-<?= $incidentID ?>"><?= $incidentID ?></th>
                                        <td id="residentName-<?= $incidentID ?>">
                                            <div style="font-weight:600;color:#222;"><?= htmlspecialchars($residentName) ?></div>
                                            <div style="font-size:0.72rem;color:#999;"><?= htmlspecialchars($residentAddress) ?></div>
                                        </td>
                                        <td id="incidentType-<?= $incidentID ?>"><span class="type-badge <?= $typeClass ?>"><?= htmlspecialchars($incidentType) ?></span></td>
                                        <td id="incidentDate-<?= $incidentID ?>"><?= date('M d, Y', strtotime($incidentDate)) ?></td>
                                        <td id="location-<?= $incidentID ?>"><?= htmlspecialchars($location) ?></td>
                                        <td id="status-<?= $incidentID ?>"><span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($status) ?></span></td>
                                        <td>
                                            <div class="action-cell">
                                                <button class="btn btn-info" onclick="viewIncident(<?= $incidentID ?>)" title="View"><i class="fa-solid fa-eye"></i></button>
                                                <button class="btn btn-dark" onclick="updateIncident(<?= $incidentID ?>)" title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                                <button class="btn btn-danger" onclick="deleteIncident(<?= $incidentID ?>)" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function () {
            $('.masterlist-table').DataTable({
                scrollX: true,
                columnDefs: [
                    { orderable: false, searchable: false, targets: 6 }
                ],
                language: {
                    emptyTable: "No incidents found",
                    zeroRecords: "No matching incidents found"
                }
            });
        });

        // Store incident data for modals
        const incidentData = <?php echo json_encode($incidents); ?>;

        function getIncidentById(id) {
            return incidentData.find(inc => inc.tbl_incident_id == id);
        }

        function viewIncident(id) {
            const inc = getIncidentById(id);
            if (!inc) return;

            const statusClass = inc.status.toLowerCase().replace(/ /g, '-');
            const typeClass = inc.incident_type.toLowerCase().replace(/ /g, '-');

            const content = `
                <div class="view-detail">
                    <div class="detail-label">Incident ID</div>
                    <div class="detail-value">INC-${String(inc.tbl_incident_id).padStart(4, '0')}</div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Resident</div>
                    <div class="detail-value">${inc.full_name || 'Unknown'}</div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Address</div>
                    <div class="detail-value">${inc.address || 'N/A'}</div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Contact</div>
                    <div class="detail-value">${inc.contact_number || 'N/A'}</div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Type</div>
                    <div class="detail-value"><span class="type-badge ${typeClass}">${inc.incident_type}</span></div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Date</div>
                    <div class="detail-value">${new Date(inc.incident_date).toLocaleDateString('en-US', { year:'numeric', month:'long', day:'numeric' })}</div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Location</div>
                    <div class="detail-value">${inc.location}</div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Status</div>
                    <div class="detail-value"><span class="status-badge ${statusClass}">${inc.status}</span></div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Description</div>
                    <div class="detail-value">${inc.description || 'No description provided.'}</div>
                </div>
                <div class="view-detail">
                    <div class="detail-label">Date Reported</div>
                    <div class="detail-value">${new Date(inc.date_reported).toLocaleString('en-US', { year:'numeric', month:'long', day:'numeric', hour:'2-digit', minute:'2-digit' })}</div>
                </div>
            `;

            $("#viewIncidentContent").html(content);
            $("#viewIncidentModal").modal("show");
        }

        function updateIncident(id) {
            const inc = getIncidentById(id);
            if (!inc) return;

            $("#updateIncidentID").val(inc.tbl_incident_id);
            $("#updateResident").val(inc.tbl_resident_id);
            $("#updateIncidentType").val(inc.incident_type);
            $("#updateIncidentDate").val(inc.incident_date);
            $("#updateLocation").val(inc.location);
            $("#updateStatus").val(inc.status);
            $("#updateDescription").val(inc.description || '');

            $("#updateIncidentModal").modal("show");
        }

        function deleteIncident(id) {
            if (confirm("Do you want to delete this incident record?")) {
                window.location = "./endpoint/delete-incident.php?incident=" + id;
            }
        }
    </script>
</body>
</html>