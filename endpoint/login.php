<?php
include ('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data, including user_id
    $stmt = $conn->prepare("SELECT `tbl_user_id`, `password` FROM `tbl_user` WHERE `username` = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $user_id = $row['tbl_user_id'];
        $stored_password = $row['password'];

        if ($password === $stored_password) {
            // Insert login history
            $insertStmt = $conn->prepare("INSERT INTO `tbl_login_history` (`user_id`, `login_time`) VALUES (:user_id, NOW())");
            $insertStmt->bindParam(':user_id', $user_id);
            $insertStmt->execute();

            echo "
            <script>
                alert('Login Successfully!');
                window.location.href = 'http://localhost/login-system-with-login-history/home.php/';
            </script>
            "; 
        } else {
            echo "
            <script>
                alert('Login Failed, Incorrect Password!');
                window.location.href = 'http://localhost/login-system-with-login-history/';
            </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('Login Failed, User Not Found!');
                window.location.href = 'http://localhost/login-system-with-login-history/';
            </script>
            ";
    }
}
?>
