<?php
include('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tbl_incident_id = $_POST['tbl_incident_id'] ?? '';
    $tbl_resident_id = $_POST['tbl_resident_id'] ?? '';
    $incident_type = $_POST['incident_type'] ?? '';
    $incident_date = $_POST['incident_date'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $status = $_POST['status'] ?? 'Pending';
    $description = trim($_POST['description'] ?? '');

    if (empty($tbl_incident_id) || empty($tbl_resident_id) || empty($incident_type) || empty($incident_date) || empty($location)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit;
    }

    try {
        $stmt = $conn->prepare("
            UPDATE tbl_incident 
            SET tbl_resident_id = ?, incident_type = ?, incident_date = ?, description = ?, status = ?, location = ?
            WHERE tbl_incident_id = ?
        ");
        $stmt->execute([$tbl_resident_id, $incident_type, $incident_date, $description, $status, $location, $tbl_incident_id]);

        echo "<script>alert('Incident updated successfully.'); window.location.href='../incidents.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
    header('Location: ../incidents.php');
    exit;
}