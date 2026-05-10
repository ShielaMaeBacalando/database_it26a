<?php
include ('../conn/conn.php');

if (isset($_GET['resident'])) {
    $resident = $_GET['resident'];

    try {

        $query = "DELETE FROM tbl_resident WHERE tbl_resident_id = '$resident'";

        $stmt = $conn->prepare($query);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
                <script>
                    alert('Resident deleted successfully!');
                    window.location.href = 'http://localhost/barangay-population-monitoring-system/masterlist.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Failed to delete resident!');
                    window.location.href = 'http://localhost/barangay-population-monitoring-system/masterlist.php';
                </script>
            ";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>