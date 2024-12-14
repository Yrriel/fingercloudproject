<?php
// Assuming you have a MySQL database with a table called 'fingerprints' with columns: 'fingerprint_index', 'fingerprint_id', and 'esp32_serial_number'
require 'connection.php';
$inputData = json_decode(file_get_contents('php://input'), true);

if (isset($inputData['index']) && isset($inputData['fingerprintId']) && isset($inputData['serialNumber'])) {
    $index = $inputData['index'];
    $fingerprintId = $inputData['fingerprintId'];
    $serialNumber = $inputData['serialNumber'];


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert fingerprint data into the database
    $sql = "INSERT INTO tablelistfingerprintenrolled (ESP32SerialNumber, indexFingerprint) 
            VALUES ($serialNumber, $fingerprintId)";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
}
?>
