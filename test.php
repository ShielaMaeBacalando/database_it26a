<?php
// Test 1: Can we find conn.php?
echo "<h3>Test 1: conn.php exists?</h3>";
if (file_exists('conn.php')) {
    echo "<p style='color:green;'>YES - conn.php found</p>";
} else {
    echo "<p style='color:red;'>NO - conn.php NOT found in this folder!</p>";
    echo "<p>Files in this folder:</p><ul>";
    foreach (glob("*") as $f) { echo "<li>$f</li>"; }
    echo "</ul>";
    die("STOP - Fix conn.php location first");
}

// Test 2: Can we connect?
echo "<h3>Test 2: Database connection?</h3>";
require_once 'conn.php';
if (isset($conn)) {
    echo "<p style='color:green;'>YES - Connected successfully</p>";
} else {
    echo "<p style='color:red;'>NO - \$conn not set</p>";
    die("STOP - Connection failed");
}

// Test 3: Does tbl_resident table exist?
echo "<h3>Test 3: tbl_resident table?</h3>";
try {
    $stmt = $conn->query("SELECT COUNT(*) FROM tbl_resident");
    $count = $stmt->fetchColumn();
    echo "<p style='color:green;'>YES - $count residents found</p>";
} catch (PDOException $e) {
    echo "<p style='color:red;'>NO - " . $e->getMessage() . "</p>";
}

// Test 4: Does tbl_incident table exist?
echo "<h3>Test 4: tbl_incident table?</h3>";
try {
    $stmt = $conn->query("SELECT COUNT(*) FROM tbl_incident");
    $count = $stmt->fetchColumn();
    echo "<p style='color:green;'>YES - $count incidents found</p>";
} catch (PDOException $e) {
    echo "<p style='color:red;'>NO - " . $e->getMessage() . "</p>";
    echo "<p style='color:orange;'>You need to create the table first! Run the SQL below in phpMyAdmin.</p>";
}

echo "<hr><h3>All Tests Complete</h3>";
?>