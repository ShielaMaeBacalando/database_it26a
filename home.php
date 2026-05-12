<?php include ('./conn/conn.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration and Login System</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        .main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
            /* Changed height to min-height so the background stretches if the table is long */
            min-height: 92.09vh; 
            padding: 20px 15px; /* Added padding for mobile spacing */
        }

        .login, .registration {
            border-radius: 5px;
            margin: 10px;
            padding: 30px;
            width: 100%; /* Changed from fixed width */
            max-width: 450px; /* Added max-width for larger screens */
            background-color: #fff;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        .login-form, .registration-form {
            margin-top: 30px;
        }

        .registrationForm {
            font-size: 13px;
            margin-top: -15px;
            color: blue;
            text-decoration: underline;
            text-align: center;
            cursor: pointer;
        }

        .container {
            border-radius: 5px;
            background-color: #fff;
            padding: 20px;
            /* Removed height: 500px and margin-top: -50px so the box grows with content */
            width: 100%;
            max-width: 1400px; /* Prevents the box from getting too wide on ultra-wide screens */
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        #editBtn, #deleteBtn {
            font-size: 20px;
            width: 30px;
        }

        /* Optional: Makes the table text slightly smaller on mobile to fit better */
        @media (max-width: 768px) {
            .table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-2 ml-md-5" href="home.php">Barangay<span>PMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/barangay-population-monitoring-system/dashboard.php/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/barangay-population-monitoring-system/masterlist.php/">Masterlist</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="http://localhost/barangay-population-monitoring-system/home.php/">Users <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/barangay-population-monitoring-system/history.php/">History</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">My Account</a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a class="dropdown-item" href="http://localhost/barangay-population-monitoring-system/index.php">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Update Modal -->
    <div class="modal fade mt-5" id="updateUserModal" tabindex="-1" aria-labelledby="updateUser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserModal">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/update-user.php" method="POST">
                        <div class="form-group row">
                            <!-- Changed col-6 to col-sm-6 col-12 so inputs stack on very small modals -->
                            <div class="col-sm-6 col-12">
                                <input type="text" name="tbl_user_id" id="updateUserID" hidden>
                                <label for="updateFirstName">First Name:</label>
                                <input type="text" class="form-control" id="updateFirstName" name="first_name">
                            </div>
                            <div class="col-sm-6 col-12">
                                <label for="updateLastName">Last Name:</label>
                                <input type="text" class="form-control" id="updateLastName" name="last_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- Changed col-5/col-7 to col-sm-5/col-sm-7 col-12 -->
                            <div class="col-sm-5 col-12">
                                <label for="updateContactNumber">Contact Number:</label>
                                <input type="number" class="form-control" id="updateContactNumber" name="contact_number" maxlength="11">
                            </div>
                            <div class="col-sm-7 col-12">
                                <label for="updateEmail">Email:</label>
                                <input type="text" class="form-control" id="updateEmail" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="updateUsername">Username:</label>
                            <input type="text" class="form-control" id="updateUsername" name="username">
                        </div>
                        <div class="form-group">
                            <label for="updatePassword">Password:</label>
                            <input type="text" class="form-control" id="updatePassword" name="password">
                        </div>
                        <button type="submit" class="btn btn-dark login-register form-control">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="main">
        <div class="container">
            <h4>List of users</h4>
            <hr>
            
            <!-- ADDED table-responsive wrapper: Allows horizontal scrolling on mobile devices -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Email</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php 
        // Correct PDO syntax to fetch users
        $stmt = $conn->prepare("SELECT * FROM `tbl_user`");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $userID = $row['tbl_user_id'];
            $firstName = $row['first_name'];
            $lastName = $row['last_name'];
            $contactNumber = $row['contact_number'];
            $email = $row['email'];
            $username = $row['username'];
            $password = $row['password'];
        ?>
        <tr>
            <td id="userID-<?= $userID ?>"><?php echo $userID ?></td>
            <td id="firstName-<?= $userID ?>"><?php echo $firstName ?></td>
            <td id="lastName-<?= $userID ?>"><?php echo $lastName ?></td>
            <td id="contactNumber-<?= $userID ?>"><?php echo $contactNumber ?></td>
            <td id="email-<?= $userID ?>"><?php echo $email ?></td>
            <td id="username-<?= $userID ?>"><?php echo $username ?></td>
            
            <?php /* SECURITY FIX: Masked the password visually, but kept the real value in a data attribute so your JS edit function still works */ ?>
            <td id="password-<?= $userID ?>" data-pw="<?= htmlspecialchars($password) ?>">••••••••</td>
            
            <td>
                <button class="btn btn-secondary btn-sm" onclick="update_user(<?php echo $userID ?>)" title="Edit">&#9998;</button>
                <button class="btn btn-danger btn-sm" onclick="delete_user(<?php echo $userID ?>)">🗑</button>
            </td>
        </tr>    
        <?php
        }
    ?>
                    </tbody>
                </table>
            </div> <!-- End of table-responsive -->
        </div>
    </div>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- Moved custom JS below jQuery so it recognizes the $ symbol properly -->
    <script>
        // Update user
        function update_user(id) {
            $("#updateUserModal").modal("show");

            let updateUserID = $("#userID-" + id).text();
            let updateFirstName = $("#firstName-" + id).text();
            let updateLastName = $("#lastName-" + id).text();
            let updateContactNumber = $("#contactNumber-" + id).text();
            let updateEmail = $("#email-" + id).text();
            let updateUsername = $("#username-" + id).text();
            
            // UPDATED: Pull the real password from the data-pw attribute instead of the masked dots
            let updatePassword = $("#password-" + id).data("pw");

            $("#updateUserID").val(updateUserID);
            $("#updateFirstName").val(updateFirstName);
            $("#updateLastName").val(updateLastName);
            $("#updateContactNumber").val(updateContactNumber);
            $("#updateEmail").val(updateEmail);
            $("#updateUsername").val(updateUsername);
            $("#updatePassword").val(updatePassword);
        }

       // Delete user function
        function delete_user(id) {
            if (confirm("⚠️ Are you sure you want to permanently delete this user?")) {
                window.location.href = "./endpoint/delete-user.php?user=" + id;
            }
        }
    </script>
</body>
</html>