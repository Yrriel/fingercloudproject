<?php
session_start();

if(empty($_SESSION['email'])){
    header('location:login.php');
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assume the option is passed in the POST body
    $option = $_POST['option'];  // Should be either 1 or 2 (enrollment or deletion)

    if (isset($_POST['option'])) {
        $option = $_POST['option'];
        echo "Option received: " . $option;  // Debug line
    } else {
        echo "Option not set";
    }

require 'connection.php';

try {
    // Establish PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update the optionesp32 value in the settings table (id = 1)
    $stmt = $pdo->prepare("UPDATE settings SET optionesp32 = :option WHERE id = 1");

    // Execute the statement with the 'option' parameter
    $stmt->execute(['option' => $option]);

    // Return success status
    echo json_encode(['status' => 'success', 'optionesp32' => $option]);
} catch (PDOException $e) {
    // Return error status and message
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
}   
?>
