<?php
include('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tbl_resident_id = $_POST['tbl_resident_id'];
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    $stmt = $conn->prepare("UPDATE tbl_resident SET full_name = :full_name, address = :address, contact_number = :contact_number WHERE tbl_resident_id = :tbl_resident_id");
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':tbl_resident_id', $tbl_resident_id);

    if ($stmt->execute()) {
        header("Location: ../masterlist.php");
        exit();
    } else {
        echo "Error updating resident.";
    }
}
?>