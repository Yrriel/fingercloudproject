<?php
// Ensure necessary parameters are passed
if (!isset($_POST['fingerprintIndex'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing fingerprint index']);
    exit;
}

$fingerprintIndex = $_POST['fingerprintIndex'];

require 'connection.php';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update the fingerprint index in the settings table
    $stmt = $pdo->prepare("UPDATE settings SET fingerprint_id = :fingerprintIndex WHERE id = 1");
    $stmt->execute([
        ':fingerprintIndex' => $fingerprintIndex
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Fingerprint index saved successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
