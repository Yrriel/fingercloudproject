<?php
require 'connection.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the fingerprint ID from the database or generate dynamically
    $stmt = $pdo->query("SELECT fingerprint_id FROM settings LIMIT 1"); // Replace with your logic
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo json_encode(['fingerprintID' => $row['fingerprint_id']]);
    } else {
        echo json_encode(['fingerprintID' => 1]); // Default fallback ID
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>
