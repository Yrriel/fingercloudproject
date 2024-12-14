<?php
header('Content-Type: application/json'); // Set the content type to JSON
require 'connection.php';  // Ensure you have a proper database connection file

// Check if the POST variable is set
if (isset($_POST['DigitalSerialNumber']) && !empty($_POST['DigitalSerialNumber'])) {
    // Sanitize the input to prevent SQL injection
    $digitalSerialNumber = $conn->real_escape_string($_POST['DigitalSerialNumber']); 

    // First, check if the UID exists in the 'tablelistowner' table
    $checkSql = "SELECT * FROM `tablelistowner` WHERE `UID` = '$digitalSerialNumber'";
    $result = $conn->query($checkSql);

    // If the UID exists, proceed with insert and update
    if ($result->num_rows > 0) {
        // Prepare the SQL query to insert into 'tablelistfingerprintenrolled' and update 'tablelistowner'
        $sql = "
            INSERT INTO `tablelistfingerprintenrolled` (ESP32SerialNumber) VALUES ('$digitalSerialNumber');
            UPDATE `tablelistowner` 
            SET `UID` = 'not set', `ESP32SerialNumber` = '$digitalSerialNumber' 
            WHERE `UID` = '$digitalSerialNumber'
        ";

        // Execute the multiple queries
        if ($conn->multi_query($sql)) {
            // Check if the queries were successful
            echo json_encode(["success" => true, "message" => "Record added and updated successfully"]);
        } else {
            // Error handling in case the queries fail
            echo json_encode(["success" => false, "message" => "Error executing SQL: " . $conn->error]);
        }
    } else {
        // If the UID doesn't exist in the 'tablelistowner' table
        echo json_encode(["success" => false, "message" => "No record found with the provided UID"]);
    }
} else {
    // If the DigitalSerialNumber is missing or invalid
    echo json_encode(["success" => false, "message" => "Invalid or missing DigitalSerialNumber"]);
}

// Close the database connection
$conn->close();
?>
