<?php

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if required parameters are provided
if (!isset($_GET['serialNumber']) || !isset($_GET['index']) || !isset($_GET['step'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit;
}

// Extract parameters
$serialNumber = $_GET['serialNumber'];
$fingerprintIndex = intval($_GET['index']);
$enrollmentStep = intval($_GET['step']);

// Validate parameters
if ($fingerprintIndex < 0 || !in_array($enrollmentStep, [1, 2])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

// Connect to the database
require 'connection.php';

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Mock interaction with ESP32 for this example
// Replace this with the actual communication logic (e.g., HTTP request, serial communication)
function communicateWithESP32($serialNumber, $fingerprintIndex, $enrollmentStep) {
    // Simulate successful response (replace with actual logic for checking fingerprint match)
    if ($enrollmentStep === 2) {
        // Simulate fingerprint match
        return [
            'status' => 'success',
            'message' => 'Second fingerprint enrolled successfully'
        ];
    } else {
        return [
            'status' => 'success',
            'message' => 'First fingerprint enrolled successfully'
        ];
    }
}

// Simulate ESP32 communication
$esp32Response = communicateWithESP32($serialNumber, $fingerprintIndex, $enrollmentStep);

// Check ESP32 response
if ($esp32Response['status'] !== 'success') {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'ESP32 enrollment failed']);
    exit;
}

// If step 2 is completed, save fingerprint information to the database
if ($enrollmentStep === 2) {
    // Assume successful fingerprint match (replace with actual matching logic)
    $fingerprintMatched = true;  // Replace with actual fingerprint match check

    if ($fingerprintMatched) {
        // Insert the enrolled fingerprint data into the database
        $stmt = $pdo->prepare("INSERT INTO `tablelistfingerprintenrolled` (`ESP32SerialNumber`, `indexFingerprint`) 
                               VALUES (:serialNumber, :fingerprintIndex)");
        $stmt->execute([
            ':serialNumber' => $serialNumber,
            ':fingerprintIndex' => $fingerprintIndex
        ]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Fingerprint enrollment completed and ID inserted'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Fingerprint mismatch. Enrollment failed.'
        ]);
        http_response_code(500);
    }
} else {
    echo json_encode([
        'status' => 'success',
        'message' => $esp32Response['message']
    ]);
}

?>
