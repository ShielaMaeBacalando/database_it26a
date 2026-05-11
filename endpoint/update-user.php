<?php
include('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID        = $_POST['tbl_user_id'];
    $firstName     = $_POST['first_name'];
    $lastName      = $_POST['last_name'];
    $contactNumber = $_POST['contact_number'];
    $email         = $_POST['email'];
    $username      = $_POST['username'];
    $password      = $_POST['password'];

    $stmt = $conn->prepare("UPDATE tbl_user SET 
        first_name     = :first_name, 
        last_name      = :last_name, 
        contact_number = :contact_number, 
        email          = :email, 
        username       = :username, 
        password       = :password 
        WHERE tbl_user_id = :id");

    $stmt->bindParam(':first_name',     $firstName);
    $stmt->bindParam(':last_name',      $lastName);
    $stmt->bindParam(':contact_number', $contactNumber);
    $stmt->bindParam(':email',          $email);
    $stmt->bindParam(':username',       $username);
    $stmt->bindParam(':password',       $password);
    $stmt->bindParam(':id',             $userID, PDO::PARAM_INT);
    $stmt->execute();
}

header("Location: ../home.php");
exit();
?>
