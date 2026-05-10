<?php 
include ('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['full_name'], $_POST['address'], $_POST['contact_number'])) {
        $residentID = $_POST['tbl_resident_id'];
        $fullName = $_POST['full_name'];
        $address = $_POST['address'];
        $contactNumber = $_POST['contact_number'];

        try {
            $checkStmt = $conn->prepare("SELECT full_name FROM tbl_resident WHERE full_name = :full_name");
            $checkStmt->bindParam(":full_name", $fullName, PDO::PARAM_STR);
            $checkStmt->execute();

            $residentExist = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if (empty($residentExist)) {
                $conn->beginTransaction();

                $stmt = $conn->prepare("UPDATE tbl_resident SET full_name = :full_name, address = :address, contact_number = :contact_number WHERE tbl_resident_id = :tbl_resident_id");

                $stmt->bindParam(":tbl_resident_id", $residentID, PDO::PARAM_STR);
                $stmt->bindParam(":full_name", $fullName, PDO::PARAM_STR);
                $stmt->bindParam(":address", $address, PDO::PARAM_STR);
                $stmt->bindParam(":contact_number", $contactNumber, PDO::PARAM_STR);

                $stmt->execute();
                $conn->commit();

                echo "
                    <script>
                        alert('Resident updated successfully!');
                        window.location.href = 'http://localhost/barangay-population-monitoring-system/masterlist.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Name already exists!');
                        window.location.href = 'http://localhost/barangay-population-monitoring-system/masterlist.php';
                    </script>
                ";
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    } else {
        echo "
            <script>
                alert('Fill all the inputs!');
                window.location.href = 'http://localhost/online-timesheet/';
            </script>
        ";
    }
}

?>