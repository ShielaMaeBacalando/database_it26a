<?php
include('../conn/conn.php');

if (isset($_GET['user'])) {
    $userID = $_GET['user'];

    try {
        // Start transaction para safe
        $conn->beginTransaction();

        // 1. Una, i-delete ang tanan login history sa niyang user
        $stmtHistory = $conn->prepare("DELETE FROM tbl_login_history WHERE user_id = :id");
        $stmtHistory->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmtHistory->execute();

        // 2. Dayon, i-delete na ang user mismo
        $stmtUser = $conn->prepare("DELETE FROM tbl_user WHERE tbl_user_id = :id");
        $stmtUser->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmtUser->execute();

        // Commit ang changes kung successful ang duha
        $conn->commit();

    } catch (Exception $e) {
        // I-rollback kung naay error
        $conn->rollBack();
        // Optional: pwede nimo i-display ang error para debugging
        // echo "Error: " . $e->getMessage();
    }
}

header("Location: ../home.php");
exit();
?>