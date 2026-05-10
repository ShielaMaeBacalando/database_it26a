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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: linear-gradient(to left, #BDBBBE 0%, #9D9EA3 100%), radial-gradient(88% 271%, rgba(255, 255, 255, 0.25) 0%, rgba(254, 254, 254, 0.25) 1%, rgba(0, 0, 0, 0.25) 100%), radial-gradient(50% 100%, rgba(255, 255, 255, 0.30) 0%, rgba(0, 0, 0, 0.30) 100%);
            background-blend-mode: normal, lighten, soft-light;
        }

        .main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 93.6vh;
        }

        .masterlist-container {
            display: flex;
            flex-direction: column;
            background-color: rgb(255, 255, 255);
            padding: 30px;
            width: 85%;
            height: 750px;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .dataTables_wrapper {
            position: relative;
            padding: 10px;
            height: 630px !important;
            text-align: center !important;
        }

        .dataTables_info {
            position: absolute;
            bottom: 10px;
            left: 10px;
        }

        .dataTables_paginate {
            position: absolute;
            bottom: 10px;
            right: 0px;
        }

        table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting_asc_disabled, table.dataTable thead > tr > th.sorting_desc_disabled, table.dataTable thead > tr > td.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting_asc_disabled, table.dataTable thead > tr > td.sorting_desc_disabled {
            text-align: center;
        }
        
        .action-button {
            display: flex;
            justify-content: center;
        }
        
        .action-button > button {
            width: 28px;
            height: 28px;
            font-size: 17px;
            display: flex !important;
            justify-content: center;
            align-items: center;
            margin: 0px 2px;
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
                <li class="nav-item ">
                    <a class="nav-link mr-2" href="./dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link mr-2" href="">Masterlist</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link mr-2" href="./home.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link mr-2" href="./history.php">History</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link mr-2" href="./index.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="main">

        <div class="masterlist-container">
            <div class="masterlist-header row">
                <h4 class="col-10">Barangay Masterlist</h4>
                <button class="btn btn-dark ml-5" data-toggle="modal"
                 data-target="#addResidentModal">Add Resident</button>
            </div>
            <hr>

            <!-- Add Resident Modal -->
            <div class="modal fade" id="addResidentModal" tabindex="-1" aria-labelledby="addResident" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content mt-5">
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
                                    <input type="text" class="form-control" id="fullName" name="full_name">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <select class="form-control" name="address" id="address">
                                        <option>-select-</option>
                                        <option value="Purkok 1">Purok 1</option>
                                        <option value="Purok 2">Purok 2</option>
                                        <option value="Purok 3">Purok 3</option>
                                        <option value="Purok 4">Purok 4</option>
                                        <option value="Purok 5">Purok 5</option>
                                        <option value="Purok 6">Purok 6</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="contactNumber">Contact Number:</label>
                                    <input type="text" class="form-control" id="contactNumber" name="contact_number">
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
                <div class="modal-dialog">
                    <div class="modal-content mt-5">
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
                                        <option>-select-</option>
                                        <option value="Purkok 1">Purok 1</option>
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

            <div class="table-container">
                <table class="table table-sm masterlist-table text-center">
                    <thead>
                        <tr>
                        <th scope="col">Resident ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Purok Located</th>
                        <th scope="col">Contact Number</th>
                        <th class="action-button" scope="col">Action</th>
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
                                    <td class="action-button">
                                        <button class="btn btn-dark" onclick="updateResident(<?= $residentID ?>)"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="btn btn-danger" onclick="deleteResident(<?= $residentID ?>)"><i class="fa-solid fa-trash"></i></button>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready( function () {
            $('.masterlist-table').DataTable();
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