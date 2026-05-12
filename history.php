<?php include ('./conn/conn.php'); ?>

<!-- ADDED: Clear History Handler -->
<?php
if (isset($_POST['clear_history'])) {
    $clearStmt = $conn->prepare("TRUNCATE TABLE tbl_login_history");
    $clearStmt->execute();
    echo "<script>alert('Login history has been cleared!'); window.location.href='history.php';</script>";
}
?>
<!-- END: Clear History Handler -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login History</title>

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
            background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
            min-height: 92.09vh; 
            padding: 20px 15px;
        }

        .login, .registration {
            border-radius: 5px;
            margin: 10px;
            padding: 30px;
            width: 100%;
            max-width: 450px;
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
            width: 100%;
            max-width: 1200px;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        #editBtn, #deleteBtn {
            font-size: 20px;
            width: 30px;
        }

        /* ADDED: Style for the header row with button */
        /* ADDED: Style for the header row with button */
.header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;       /* Allows wrapping on small screens */
    gap: 10px;             /* Spacing between title and button */
}
.btn-clear-history {
    background-color: #dc3545;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 6px 18px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    white-space: nowrap;   /* Prevents button text from breaking */
}
.btn-clear-history:hover {
    background-color: #c82333;
}

@media (max-width: 768px) {
    .table {
        font-size: 14px;
    }
    /* ADDED: Stack header row vertically on mobile */
    .header-row {
        flex-direction: column;
        align-items: flex-start;
    }
    .btn-clear-history {
        width: 100%;
        text-align: center;
    }
}
    </style>
</head>
<body>
    
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand ml-2 ml-md-5" href="about us.php">Barangay<span>PMS</span></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/barangay-population-monitoring-system/dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/barangay-population-monitoring-system/masterlist.php">Masterlist</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link mr-2" href="http://localhost/barangay-population-monitoring-system/incidents.php">Incidents</a>
                </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/barangay-population-monitoring-system/home.php">Users</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="http://localhost/barangay-population-monitoring-system/history.php">History <span class="sr-only">(current)</span></a>
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

    <div class="main">
        <div class="container">

            <!-- ADDED: Header row with Clear History button -->
            <div class="header-row">
                <h4>Login History</h4>
                <form method="POST" onsubmit="return confirm('Are you sure you want to clear all login history?');">
                    <button type="submit" name="clear_history" class="btn-clear-history">Clear History</button>
                </form>
            </div>
            <!-- END: Header row with Clear History button -->

            <hr>
            
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
                        <th scope="col">Login Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $stmt = $conn->prepare("
                                SELECT 
                                    tbl_user.tbl_user_id AS userID,
                                    tbl_user.first_name AS firstName,
                                    tbl_user.last_name AS lastName,
                                    tbl_user.contact_number AS contactNumber,
                                    tbl_user.email AS email,
                                    tbl_user.username AS username,
                                    tbl_user.password AS password,
                                    tbl_login_history.login_time AS lastLoginTime
                                FROM 
                                    tbl_user
                                LEFT JOIN 
                                    tbl_login_history
                                ON 
                                    tbl_user.tbl_user_id = tbl_login_history.user_id
                            ");
                            $stmt->execute();

                            $result = $stmt->fetchAll();

                            foreach ($result as $row) {
                                $userID = $row['userID'];
                                $firstName = $row['firstName'];
                                $lastName = $row['lastName'];
                                $contactNumber = $row['contactNumber'];
                                $email = $row['email'];
                                $username = $row['username'];
                                $password = $row['password'];
                                $lastLoginTime = $row['lastLoginTime'];
                        ?>
                            <tr>
                                <td id="userID-<?= $userID ?>"><?php echo $userID ?></td>
                                <td id="firstName-<?= $userID ?>"><?php echo $firstName ?></td>
                                <td id="lastName-<?= $userID ?>"><?php echo $lastName ?></td>
                                <td id="contactNumber-<?= $userID ?>"><?php echo $contactNumber ?></td>
                                <td id="email-<?= $userID ?>"><?php echo $email ?></td>
                                <td id="username-<?= $userID ?>"><?php echo $username ?></td>
                                <td id="password-<?= $userID ?>">••••••••</td>
                                <td id="lastLoginTime-<?= $userID ?>"><?php echo $lastLoginTime ? $lastLoginTime : 'No login history'; ?></td>
                            </tr>    
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>