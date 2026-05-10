<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$active_form = $_SESSION['active_form'] ?? 'login';
session_unset();

function showError($error) {
    global $errors;
    if (!empty($errors[$error])) {
        echo '<p class="error-message">' . $errors[$error] . '</p>';
    }
}

function isActiveForm($form_name, $active_form) {
    return ($form_name === $active_form) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-box <?php echo isActiveForm('login', $active_form); ?>" id="login-form">
            <form action="login_register.php" method="POST">
                <h2>Login</h2>
                <?php showError('login'); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>

        <div class="form-box <?php echo isActiveForm('register', $active_form); ?>" id="register-form" style="display: none;">
            <form action="login_register.php" method="POST">
                <h2>Register</h2>
                <?php showError('register'); ?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>