<?php
session_start();
if(empty($_SESSION['email'])){
    header('location:login.php');
    die();
}

require 'connection.php'; // Ensure this file contains your database connection details

header('Content-Type: application/json');

// Generate a unique serial number
$generatedSerial = "SN-" . strtoupper(bin2hex(random_bytes(4)));

try {
    // Replace this with the email of the target row
    $targetEmail = $_SESSION['email']; // Dynamically set this in your application

    // Prepare an UPDATE query to set the uid for the specific email
    $stmt = $conn->prepare("UPDATE tablelistowner SET uid = ? WHERE email = ?");
    
    // Bind the generated serial and the target email to the query
    $stmt->bind_param("ss", $generatedSerial, $targetEmail);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "serialNumber" => $generatedSerial]);
        } else {
            echo json_encode(["status" => "error", "message" => "No rows updated. Email not found."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update UID."]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

$conn->close();
?>
