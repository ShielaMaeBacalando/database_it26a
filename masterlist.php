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
            min-width: 620px;
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

        /* Top: Length + Filter row */
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

        /* Bottom: Info + Pagination */
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

        /* Sorting arrows centered */
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

        /* ============================= */
        /* ===== RESPONSIVE: MOBILE ==== */
        /* ============================= */
        @media (max-width: 575.98px) {
            .main {
                padding: 12px 6px;
            }
            .masterlist-container {
                padding: 14px 10px;
                border-radius: 10px;
            }
            .masterlist-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }
            .masterlist-header h4 {
                font-size: 1.1rem;
            }
            .masterlist-header .btn-add {
                width: 100%;
            }

            /* DataTables: stack length + filter */
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                float: none !important;
                text-align: left !important;
                width: 100%;
                margin-bottom: 10px;
            }
            .dataTables_wrapper .dataTables_filter input {
                width: 100%;
                margin-left: 0;
                margin-top: 4px;
                display: block;
            }
            .dataTables_wrapper .dataTables_length select {
                display: inline-block;
                width: auto;
            }

            /* DataTables: stack info + paginate */
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                float: none !important;
                text-align: center !important;
                width: 100%;
                padding-top: 6px;
            }

            /* Modal */
            .modal-dialog {
                margin: 10px;
            }
            .modal-footer {
                flex-wrap: wrap;
            }
            .modal-footer .btn {
                flex: 1;
            }

            /* Navbar */
            .navbar-nav .nav-link {
                padding: 8px 0 !important;
            }
        }

        /* ===== RESPONSIVE: TABLET ===== */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .main {
                padding: 16px 10px;
            }
            .masterlist-container {
                padding: 20px 14px;
            }

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                float: none !important;
                text-align: left !important;
                width: 100%;
                margin-bottom: 10px;
            }
            .dataTables_wrapper .dataTables_filter input {
                width: 70%;
            }

            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                float: none !important;
                text-align: center !important;
                width: 100%;
                padding-top: 6px;
            }
        }

        /* ===== RESPONSIVE: SMALL DESKTOP ===== */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .masterlist-container {
                max-width: 95%;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-lg-4" href="#">Barangay<span>PMS</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/dashboard.php/">Dashboard</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/masterlist.php/">Masterlist <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/home.php/">Users</a>
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
        <div class="masterlist-container">

            <!-- Header -->
            <div class="masterlist-header">
                <h4>Barangay Masterlist</h4>
                <button class="btn btn-dark btn-add" data-toggle="modal" data-target="#addResidentModal">
                    <i class="fa-solid fa-plus mr-1"></i> Add Resident
                </button>
            </div>
            <hr class="divider">

            <!-- Add Resident Modal -->
            <div class="modal fade" id="addResidentModal" tabindex="-1" aria-labelledby="addResident" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addResident">Add Resident</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="./endpoint/add-resident.php" method="POST">
                                <div class="form-group">
                                    <label for="fullName">Full Name:</label>
                                    <input type="text" class="form-control" id="fullName" name="full_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <select class="form-control" name="address" id="address" required>
                                        <option value="">-select-</option>
                                        <option value="Purok 1">Purok 1</option>
                                        <option value="Purok 2">Purok 2</option>
                                        <option value="Purok 3">Purok 3</option>
                                        <option value="Purok 4">Purok 4</option>
                                        <option value="Purok 5">Purok 5</option>
                                        <option value="Purok 6">Purok 6</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="contactNumber">Contact Number:</label>
                                    <input type="text" class="form-control" id="contactNumber" name="contact_number" required>
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

            <!-- Update Resident Modal -->
            <div class="modal fade" id="updateResidentModal" tabindex="-1" aria-labelledby="updateResident" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateResident">Update Resident</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="./endpoint/update-resident.php" method="POST">
                                <input type="hidden" class="form-control" id="updateResidentID" name="tbl_resident_id">

                                <div class="form-group">
                                    <label for="updateFullName">Full Name:</label>
                                    <input type="text" class="form-control" id="updateFullName" name="full_name">
                                </div>
                                <div class="form-group">
                                    <label for="updateAddress">Address:</label>
                                    <select class="form-control" name="address" id="updateAddress">
                                        <option value="">-select-</option>
                                        <option value="Purok 1">Purok 1</option>
                                        <option value="Purok 2">Purok 2</option>
                                        <option value="Purok 3">Purok 3</option>
                                        <option value="Purok 4">Purok 4</option>
                                        <option value="Purok 5">Purok 5</option>
                                        <option value="Purok 6">Purok 6</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="updateContactNumber">Contact Number:</label>
                                    <input type="text" class="form-control" id="updateContactNumber" name="contact_number">
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

            <!-- Table -->
            <div class="table-container">
                <table class="table table-sm masterlist-table">
                    <thead>
                        <tr>
                            <th scope="col">Resident ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Purok Located</th>
                            <th scope="col">Contact Number</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include ('./conn/conn.php');

                            $stmt = $conn->prepare("SELECT * FROM tbl_resident");
                            $stmt->execute();

                            $result = $stmt->fetchAll();

                            foreach ($result as $row) {
                                $residentID = $row['tbl_resident_id'];
                                $fullName = $row['full_name'];
                                $address = $row['address'];
                                $contactNumber = $row['contact_number'];
                        ?>
                                <tr>
                                    <th id="residentID-<?= $residentID ?>"><?= $residentID ?></th>
                                    <td id="fullName-<?= $residentID ?>"><?= $fullName ?></td>
                                    <td id="address-<?= $residentID ?>"><?= $address ?></td>
                                    <td id="contactNumber-<?= $residentID ?>"><?= $contactNumber ?></td>
                                    <td>
                                        <div class="action-cell">
                                            <button class="btn btn-dark" onclick="updateResident(<?= $residentID ?>)" title="Edit"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-danger" onclick="deleteResident(<?= $residentID ?>)" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- jQuery (full — required by DataTables) -->
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
                    { orderable: false, searchable: false, targets: 4 }
                ],
                language: {
                    emptyTable: "No residents found",
                    zeroRecords: "No matching residents found"
                }
            });
        });

        function updateResident(id) {
            $("#updateResidentModal").modal("show");

            let updateResidentID = $("#residentID-" + id).text();
            let updateFullName = $("#fullName-" + id).text();
            let updateAddress = $("#address-" + id).text();
            let updateContactNumber = $("#contactNumber-" + id).text();

            $("#updateResidentID").val(updateResidentID);
            $("#updateFullName").val(updateFullName);
            $("#updateAddress option").each(function() {
                let address = $(this).text();
                if (address === updateAddress) {
                    $(this).prop("selected", true);
                    return false;
                }
            });
            $("#updateContactNumber").val(updateContactNumber);
        }

        function deleteResident(id) {
            if (confirm("Do you want to delete this resident?")) {
                window.location = "./endpoint/delete-resident.php?resident=" + id;
            }
        }
    </script>
</body>
</html>