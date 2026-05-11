<?php
// 1. Connect to your database using your existing connection file
include ('../conn/conn.php'); 

if (isset($_GET['user'])) {
    $user_id = $_GET['user'];

    try {
        // 2. Prepare the DELETE SQL command
        // This command tells the database to find the user with this ID and erase them.
        $query = "DELETE FROM `tbl_user` WHERE `tbl_user_id` = :id";
        $stmt = $conn->prepare($query);
        
        // 3. Bind the ID to prevent SQL Injection
        $stmt->bindParam(':id', $user_id);
        
        // 4. Execute the command
        if ($stmt->execute()) {
            echo "
            <script>
                alert('User deleted from database successfully!');
                window.location.href = '../home.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Error: Could not remove user from database.');
                window.location.href = '../home.php';
            </script>
            ";
        }

    } catch (PDOException $e) {
        // This will show you a message if there is a database connection error
        echo "Database Error: " . $e->getMessage();
    }
}
?>