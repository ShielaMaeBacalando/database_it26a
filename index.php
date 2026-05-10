<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hardcoded admin credentials for demonstration purposes
    $adminUsername = "admin";
    $adminPassword = "admin";

    // Get user input
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Check if entered credentials match the admin credentials
    if ($enteredUsername === $adminUsername && $enteredPassword === $adminPassword) {
        // Redirect to dashboard.php on successful login
        header("Location: dashboard.php");
        exit();
    } else {
        // Display an error message if credentials are incorrect
        $errorMessage = "Invalid username or password.";
    }
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
        }

        .main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            background-color: rgb(255, 255, 255);
            padding: 30px;
            width: 450px;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        .login-container > img  {
            width: 150px;
            align-self: center;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="login-container">
            <img src="https://img.icons8.com/?size=256&id=VtA8PyVbcO5l&format=png" alt="">
            <h2 class="text-center">Barangay Population Monitoring System</h2>

            <!-- Display error message if login fails -->
            <?php if (isset($errorMessage)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>

            <!-- Login form -->
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary form-control">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>