<?php
header('Content-Type: application/json');
require 'connection.php';

// Get POST data
$status = isset($_POST['status']) ? $_POST['status'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';
$serialnumber = $_POST['serialnumber'];
$indexid = $_POST['indexFingerprint'];

// Assuming you want to log the enrollment status
// For example, you could store it in a database table 'fingerprint_enrollments'

// Prepare the response
$response = [
    'success' => false,
    'message' => 'Invalid input'
];

// Validate the data
if ($status && $message) {
    $query = "SELECT * FROM `tablelistfingerprintenrolled` WHERE `ESP32SerialNumber`='$serialnumber' AND `index`='$indexid'";
    $result = $conn->query($query);
    if($result->num_rows > 0)
    // Insert into database (you need to have a `fingerprint_enrollments` table)
    $query = "UPDATE `tablelistfingerprintenrolled` SET `UID`='SET',`index`='$indexid' WHERE `ESP32SerialNumber`='$serialnumber'";
    //
    if($result->num_rows == 0){
    $query = "INSERT INTO `tablelistfingerprintenrolled`(`UID`, `ESP32SerialNumber`, `indexFingerprint`) VALUES ('SET','$serialnumber','$indexid')";   
    }
    if (mysqli_query($conn, $query)) {
        $response = [
            'success' => true,
            'message' => 'Enrollment status saved successfully',
            'SERIAL' => $serialnumber,
            'INDEX' => $indexid
        ];
    } else {
        $response = [
            $status => false,
            'message' => $message
        ];
    }
}

// Return JSON response
echo json_encode($response);
?>
