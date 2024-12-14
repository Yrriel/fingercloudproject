<?php
// Assuming you have a database connection setup
require 'connection.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the 'option' from the database
    $stmt = $pdo->query("SELECT `optionesp32` FROM `settings` LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $response = array('option' => $row['optionesp32']); // Create an associative array
        echo json_encode($response); // Return the response in JSON format
    } else {
        $response = array('option' => 1); // Default to enrollment if no option is found
        echo json_encode($response); // Return default value in JSON format
    }
} catch (PDOException $e) {
    // Handle error and return an error message in JSON format
    $response = array('error' => 'Error: ' . $e->getMessage());
    echo json_encode($response);
}
?>
