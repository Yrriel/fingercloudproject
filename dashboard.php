<?php

session_start();
if(empty($_SESSION['email'])){
    header('location:login.php');
    die();
}

$isAccountNew = $_SESSION['uid'];
$email = $_SESSION['email'];

if($isAccountNew == "NEW"){
    header("Location:newacount2.php");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/dashboard-style.css">
</head>
<body>
    <div class="half-circle"></div>
    <div class="headerwrapper">
        <div class="header">
            <nav class="dash-nav">
                <a class="button-menu-href" href=""><img class="button-menu" src="src/svg/icon-homeicon.svg" alt=""></a>
                <a class="button-profile-href" href="login.html"><img class="button-profile" src="src/svg/profile-icon.svg" alt="">logout</a>
            </nav>
        </div>
        <div class="section">
            <div class="wrapper">
                <div class="profile-container">
                    <span class="profile-container-span">
                        <img class="profile-picture" src="src/img/profile-sample.jpeg" alt="">
                        <span class="profile-text-box">
                            <h1>Dashboard</h1>
                            <p>No Alerts</p>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="contentwrapper"> -->
        <div class="message-alert-container">
            <div class="message-alert">
                <div class="status-container  dashboard-information">
                    <h2>Device Information</h2>
                    <div class="gap-row">
                        <div class="device-status-container">
                            <img class="icon-device-status" src="src/svg/icon-device-status.svg" alt="" srcset="">
                                <p>Device Status</p>
                                <p class="device-online">online</p>
                        </div>
                        <div class="device-status-container">
                            <img class="icon-device-status" src="src/svg/icon-wifi-ssid.svg" alt="" srcset="">
                            <p>SSID</p><p class="device-info">wifi82asdasdasdsdasd600</p>
                        </div>
                    </div>
                </div>
                <div class="status-container  dashboard-information">
                    <h2>Doorlock Information</h2>
                    <div class="gap-row">
                        <div class="device-status-container">
                            <img class="icon-device-status" src="src/svg/icon-lock-status.svg" alt="" srcset="">
                                <p>Doorlock Status</p>
                                <p class="doorlock-unlocked">unlocked</p>
                        </div>
                        <div class="device-status-container">
                            <img class="icon-device-status" src="src/svg/icon-last-open.svg" alt="" srcset="">
                            <p>Last unlocked</p><p class="device-info">12/13/2024 21:04</p>
                        </div>
                        <div class="device-status-container">
                            <img class="icon-device-status" src="src/svg/icon-last-person.svg" alt="" srcset="">
                            <p>Last Person</p><p class="device-info">Lucy</p>
                        </div>
                    </div>
                </div>
                <!-- <p>Hola. Using this ui for login page for testing purposes.</p>
                <p>Can't interact with other buttons. Only Fingerprint button works</p> -->
            </div>
        </div>
    
        <div class="choices">
            <!-- <a class="icons-size icons-disabled" href="#"><div class="center-this"><img src="src/svg/button-wifi.svg" alt=""></div><p>Wifi settings</p></a> -->
            <a class="icons-size icons-working" href="userlist.php"><div class="center-this"><img src="src/svg/button-fingerprint.svg" alt=""></div><p>Fingerprint</p></a>
            <a class="icons-size row2 icons-disabled" href="#"><div class="center-this"><img src="src/svg/button-log.svg" alt=""></div><p>Activity Logs</p></a>
            <a class="icons-size row2 icons-disabled" href="#"><div class="center-this"><img src="src/svg/button-security.svg" alt=""></div><p>Security Settings</p></a>
        </div>
    <!-- </div> -->
</body>
</html>