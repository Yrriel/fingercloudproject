<?php
// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the 'option' value passed in the POST request
    $option = $_POST['option'];

    // Database connection
    require 'connection.php';

    try {
        // Establish PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the optionesp32 value to enable fingerprint scanning
        $stmt = $pdo->prepare("UPDATE settings SET `optionesp32` = :option WHERE id = 1");
                                    //UPDATE `settings` SET `id`='1' WHERE `id`= '0'
        $stmt->execute(['option' => $option]);

        // Return success status in JSON format
        echo json_encode(['status' => 'success', 'optionesp32' => $option]);
    } catch (PDOException $e) {
        // Return error status and message if the query fails
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
