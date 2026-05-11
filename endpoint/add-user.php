<?php
// Gamita '../' para mo-back sa parent folder kay naa ka sa 'endpoint' folder
include('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName     = $_POST['first_name'];
    $lastName      = $_POST['last_name'];
    $contactNumber = $_POST['contact_number'];
    $email         = $_POST['email'];
    $username      = $_POST['username'];
    $password      = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO tbl_user (first_name, last_name, contact_number, email, username, password) 
                            VALUES (:first_name, :last_name, :contact_number, :email, :username, :password)");

    $stmt->bindParam(':first_name',     $firstName);
    $stmt->bindParam(':last_name',      $lastName);
    $stmt->bindParam(':contact_number', $contactNumber);
    $stmt->bindParam(':email',          $email);
    $stmt->bindParam(':username',       $username);
    $stmt->bindParam(':password',       $password);
    
    $stmt->execute();
}

// Mo-balik sa registration/login page pag-human
header("Location: ../index.php");
exit();
?>