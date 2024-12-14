<?php
header('Content-Type: application/json');

// Include the database connection
require 'connection.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle log submission from ESP32
        $status = $_POST['status'] ?? 'unknown';

        // Update or insert the log into the database
        $stmt = $pdo->prepare("UPDATE `fingerprint_status` SET `status` = :status WHERE `id` = 1");
        $stmt->execute(['status' => $status]);

        echo json_encode(['status' => 'success', 'message' => 'Log updated successfully']);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch the latest status for the frontend
        $stmt = $pdo->query("SELECT `status` FROM `fingerprint_status` LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo json_encode(['status' => $row['status']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No status found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
