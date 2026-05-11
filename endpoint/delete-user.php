<?php
include('../conn/conn.php');

if (isset($_GET['user'])) {
    $userID = $_GET['user'];

    $stmt = $conn->prepare("DELETE FROM tbl_user WHERE tbl_user_id = :id");
    $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
    $stmt->execute();
}

header("Location: ../home.php");
exit();
?>