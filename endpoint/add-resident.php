<?php
include('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];

    $stmt = $conn->prepare("INSERT INTO tbl_resident (full_name, address, contact_number) VALUES (:full_name, :address, :contact_number)");
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':contact_number', $contact_number);

    if ($stmt->execute()) {
        header("Location: ../masterlist.php");
        exit();
    } else {
        echo "Error adding resident.";
    }
}
?>