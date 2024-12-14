<?php
header('Content-Type: application/json');
require 'connection.php';

// Define the global option variable
$option = 0; // Default value

// ESP32 endpoint (replace with your ESP32's actual address)
define('ESP32_API_URL', 'http://192.168.1.100'); // Example ESP32 IP address

/**
 * Send a command to the ESP32 device.
 *
 * @param int $command The command to send to the ESP32.
 * @return array The response from the ESP32 or an error message.
 */
function sendCommandToESP32($command) {
    $url = ESP32_API_URL . '/control';
    $data = ['command' => $command];

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data),
            'timeout' => 10
        ]
    ];

    $context = stream_context_create($options);
    try {
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            throw new Exception('Failed to communicate with ESP32');
        }
        return json_decode($result, true);
    } catch (Exception $e) {
        return [
            "success" => false,
            "message" => $e->getMessage()
        ];
    }
}

// Check if there's a POST request to update the option
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['option'])) {
    $option = intval($_POST['option']);

    // Send the command to the ESP32
    $esp32Response = sendCommandToESP32($option);

    if ($esp32Response['success']) {
        // Return success message and ESP32 response
        $response = [
            "success" => true,
            "message" => "Command sent successfully to ESP32",
            "esp32Response" => $esp32Response
        ];
    } else {
        // Return error if ESP32 communication fails
        $response = [
            "success" => false,
            "message" => "Failed to send command to ESP32",
            "error" => $esp32Response['message']
        ];
    }
    echo json_encode($response);
} else {
    // Provide the current option as a response
    $response = [
        "success" => true,
        "option" => $option
    ];
    echo json_encode($response);
}
?>
