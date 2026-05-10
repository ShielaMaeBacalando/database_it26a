<?php 
include ('../conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['full_name'], $_POST['address'], $_POST['contact_number'])) {
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

                $stmt = $conn->prepare("INSERT INTO tbl_resident (full_name, address, contact_number) VALUES (:full_name, :address, :contact_number)");
    
                $stmt->bindParam(":full_name", $fullName, PDO::PARAM_STR);
                $stmt->bindParam(":address", $address, PDO::PARAM_STR);
                $stmt->bindParam(":contact_number", $contactNumber, PDO::PARAM_STR);
    
                $stmt->execute();
                $conn->commit();
    
                echo "
                    <script>
                        alert('Resident added successfully!');
                        window.location.href = 'http://localhost/barangay-population-monitoring-system/masterlist.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Resident already exists!');
                        window.location.href = 'http://localhost/barangay-population-monitoring-system/masterlist.php';
                    </script>
                ";
            }

        } catch (PDOException $e) {
            echo "
                <script>
                    alert('Error: " . $e->getMessage() . "');
                    window.location.href = 'http://localhost/barangay-population-monitoring-system/masterlist.php';
                </script>
            ";
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
