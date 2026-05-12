<?php
include('../conn/conn.php');

 $incident_id = $_GET['incident'] ?? '';

if (empty($incident_id)) {
    header('Location: ../incidents.php');
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM tbl_incident WHERE tbl_incident_id = ?");
    $stmt->execute([$incident_id]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Incident deleted successfully.'); window.location.href='../incidents.php';</script>";
    } else {
        echo "<script>alert('Incident not found.'); window.location.href='../incidents.php';</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='../incidents.php';</script>";
}