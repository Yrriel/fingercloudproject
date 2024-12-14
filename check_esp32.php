<?php
require 'connection.php';

$generatedserialnumber = $_GET['serialNumber']; // Get serial number from the request

$query = "SELECT * FROM `tablelistfingerprintenrolled` WHERE `ESP32SerialNumber` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $generatedserialnumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    echo json_encode(['status' => 'connected']);
} else {
    echo json_encode(['status' => 'waiting']);
}

$stmt->close();
$conn->close();
?>
