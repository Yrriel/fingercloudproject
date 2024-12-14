<?php 

session_start();

if(empty($_SESSION['email'])){
    header('location:login.php');
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Account Setup</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
            color: #333;
            height: 100vh;
            width: 100vw;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            color: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: none;
            background-color: #212529;
        }
        .container.active {
            display: block;
        }
        h1, h2 {
            text-align: center;
            color: #eee6ff;
        }
        p {
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input, .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            background: #6146ff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 20px;
        }
        .form-group button:disabled {
            background: #aaa;
            cursor: not-allowed;
        }
        .form-group button:hover:enabled {
            background: #4424f8;
        }
        .fingerprint-animation {
            text-align: center;
            margin: 20px 0;
        }
        .fingerprint-animation img {
            width: 150px;
            height: 150px;
            animation: pulse 1.5s infinite ease-in-out;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.7;
            }
            50% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 0.7;
            }
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Step 1: Serial Number -->
    <div class="container active" id="page-1">
        <h1>Step 1: Connect Your ESP32</h1>
        <p>Please use the following serial number to connect your ESP32 device:</p>
        <div class="serial-number" id="serial-number">Generating...</div>
        <p id="status-text">Status: Waiting for connection...</p>
        <div class="form-group">
            <button onclick="nextPage(2)" id="next-btn-1" disabled>Next</button>
        </div>
    </div>

    <!-- Step 2: Fingerprint Enrollment -->
<div class="container" id="page-2">
    <h1>Step 2: Enroll Fingerprint</h1>
    <p>Enter the fingerprint index to be used (e.g., 1, 2, 3):</p>
    <div class="form-group">
        <input type="number" id="fingerprint-index" placeholder="Enter fingerprint index">
        <button onclick="saveFingerprintIndex()" id="save-fingerprint-btn">Save Fingerprint Index</button>
    </div>
    <p>Place your finger on the fingerprint sensor when prompted.</p>
    <div class="fingerprint-animation">
        <img src="https://via.placeholder.com/150?text=Fingerprint" alt="Fingerprint Animation">
    </div>
    <p id="step-2-status">Status: Waiting for input...</p>
    <div class="form-group">
        <button onclick="startFingerprintEnrollment()" id="start-enrollment-btn">Start Enrollment</button>
    </div>
    <div class="form-group">
        <button id="next-btn-2" disabled onclick="nextPage(3)">Next</button>
    </div>
</div>
    <!-- Step 3: User Details -->
    <div class="container" id="page-3">
        <h1>Step 3: Personal Information</h1>
        <form id="user-details-form">
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first-name" placeholder="Enter your first name">
            </div>
            <div class="form-group">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last-name" placeholder="Enter your last name">
            </div>
            <div class="form-group">
                <button type="submit">Finish</button>
            </div>
        </form>
    </div>

    <script>
        let serialNumber = '';

        // Generate serial number and check ESP32 connection
        async function generateSerialNumber() {
            const serialNumberElement = document.getElementById('serial-number');
            try {
                const response = await fetch('generate_serial.php');
                const data = await response.json();
                serialNumber = data.serialNumber;
                serialNumberElement.textContent = serialNumber;

                checkESP32Connection();
            } catch (error) {
                console.error('Error generating serial number:', error);
                serialNumberElement.textContent = 'Error generating serial number.';
            }
        }

        // Check ESP32 connection
        async function checkESP32Connection() {
            const statusText = document.getElementById('status-text');
            const nextBtn1 = document.getElementById('next-btn-1');

            const interval = setInterval(async () => {
                try {
                    const response = await fetch(`check_esp32.php?serialNumber=${serialNumber}`);
                    const data = await response.json();

                    if (data.status === 'connected') {
                        statusText.textContent = "Status: ESP32 connected successfully!";
                        nextBtn1.disabled = false;
                        clearInterval(interval);
                    }
                } catch (error) {
                    console.error('Error checking ESP32 connection:', error);
                }
            }, 3000);
        }

        // Start fingerprint enrollment process
        // async function startFingerprintEnrollment() {
        //     const indexInput = document.getElementById('fingerprint-index');
        //     const statusText = document.getElementById('step-2-status');
        //     const nextBtn2 = document.getElementById('next-btn-2');

        //     const fingerprintIndex = parseInt(indexInput.value);

        //     if (isNaN(fingerprintIndex) || fingerprintIndex < 0) {
        //         alert("Please enter a valid fingerprint index.");
        //         return;
        //     }

        //     try {
        //         statusText.textContent = "Status: Scanning first fingerprint...";
        //         await fetch(`start_fingerprint_enrollment.php?serialNumber=${serialNumber}&index=${fingerprintIndex}&step=1`);
                
        //         statusText.textContent = "Status: Scanning second fingerprint...";
        //         await fetch(`start_fingerprint_enrollment.php?serialNumber=${serialNumber}&index=${fingerprintIndex}&step=2`);

        //         statusText.textContent = "Status: Fingerprints matched successfully!";
        //         nextBtn2.disabled = false;

        //     } catch (error) {
        //         statusText.textContent = "Status: Error during enrollment. Please try again.";
        //         console.error("Error enrolling fingerprint:", error);
        //     }
        // }
        async function saveFingerprintIndex() {
        const fingerprintIndex = document.getElementById('fingerprint-index').value;
        const statusText = document.getElementById('step-2-status');

        // Validate the fingerprint index
        if (isNaN(fingerprintIndex) || fingerprintIndex <= 0) {
            alert("Please enter a valid fingerprint index.");
            return;
        }

        // Send the fingerprint index to the server to be saved in the database
        try {
            const response = await fetch('save_fingerprint_index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `fingerprintIndex=${fingerprintIndex}`
            });

            const data = await response.json();

            if (data.status === 'success') {
                statusText.textContent = 'Status: Fingerprint index saved successfully!';
                // Enable the "Start Enrollment" button
                document.getElementById('start-enrollment-btn').disabled = false;
            } else {
                statusText.textContent = 'Status: Error saving fingerprint index.';
            }
        } catch (error) {
            console.error('Error saving fingerprint index:', error);
            statusText.textContent = 'Status: Error saving fingerprint index.';
        }
    }
        
        async function startFingerprintEnrollment() {
    const fingerprintIndex = document.getElementById('fingerprint-index').value;
    const statusText = document.getElementById('step-2-status');
    const nextBtn2 = document.getElementById('next-btn-2');

    if (isNaN(fingerprintIndex) || fingerprintIndex <= 0) {
        alert("Please enter a valid fingerprint index.");
        return;
    }

    try {
        // Step 1: Enable fingerprint scanning in the database
        const updateResponse = await fetch('update_option.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `option=1`
        });

        const updateData = await updateResponse.json();

        if (updateData.status === 'success') {
            statusText.textContent = "Status: Fingerprint scanning enabled.";

            // Step 2: Start enrollment
            const enrollmentStep1 = await fetch(`start_fingerprint_enrollment.php?serialNumber=${serialNumber}&index=${fingerprintIndex}&step=1`);
            
            if (enrollmentStep1.ok) {
                statusText.textContent = "Status: Scanning second fingerprint...";

                const enrollmentStep2 = await fetch(`start_fingerprint_enrollment.php?serialNumber=${serialNumber}&index=${fingerprintIndex}&step=2`);
                const enrollmentData = await enrollmentStep2.json();

                if (enrollmentData.status === 'success') {
                    statusText.textContent = "Status: Fingerprints matched successfully!";
                    nextBtn2.disabled = false; // Enable Next button
                    
                    // Move to Step 3 after enrollment
                    nextPage(3);
                } else {
                    statusText.textContent = "Status: Fingerprint mismatch. Enrollment failed. Please try again.";
                }
            } else {
                statusText.textContent = "Status: Error scanning first fingerprint. Please try again.";
            }
        } else {
            statusText.textContent = "Status: Error enabling fingerprint scanning. Please try again.";
        }
    } catch (error) {
        statusText.textContent = "Status: Error during enrollment. Please try again.";
        console.error("Error during fingerprint enrollment:", error);
    }
}


    function pollFingerprintEnrollment(fingerprintIndex) {
    const statusText = document.getElementById('step-2-status');
    const nextBtn2 = document.getElementById('next-btn-2');
    let polling = true;

    async function pollFingerprintEnrollment() {
    const statusText = document.getElementById('step-2-status');

    const interval = setInterval(async () => {
        try {
            const response = await fetch('send_log.php');
            const data = await response.json();

            if (data.status === 'waiting') {
                statusText.textContent = "Status: Waiting for user to place a finger...";
            } else if (data.status === 'scanning') {
                statusText.textContent = "Status: Scanning fingerprint...";
            } else if (data.status === 'success') {
                statusText.textContent = "Status: Enrollment successful!";
                clearInterval(interval);
                document.getElementById('next-btn-2').disabled = false; // Enable Next button
            } else if (data.status === 'error') {
                statusText.textContent = `Status: Error - ${data.message}`;
            }
        } catch (error) {
            console.error('Error polling fingerprint status:', error);
        }
    }, 3000);
}

    // Poll every 3 seconds
    const interval = setInterval(() => {
        if (!polling) clearInterval(interval);
        fetchEnrollmentStatus();
    }, 3000);
}


        // Navigate between steps
        function nextPage(pageNumber) {
            document.querySelectorAll('.container').forEach(container => {
                container.classList.remove('active');
            });
            document.getElementById(`page-${pageNumber}`).classList.add('active');
        }

        // Initialize on page load
        window.onload = generateSerialNumber;
    </script>
</body>
</html>
