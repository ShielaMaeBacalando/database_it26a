<?php
include('../conn/conn.php');

if (isset($_GET['resident'])) {
    $tbl_resident_id = $_GET['resident'];

    $stmt = $conn->prepare("DELETE FROM tbl_resident WHERE tbl_resident_id = :tbl_resident_id");
    $stmt->bindParam(':tbl_resident_id', $tbl_resident_id);

    if ($stmt->execute()) {
        header("Location: ../masterlist.php");
        exit();
    } else {
        echo "Error deleting resident.";
    }
}
?>