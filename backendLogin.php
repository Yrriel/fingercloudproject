<?php

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //initialize connections to database
    require_once 'connection.php';

    //retrieve form data
    $email = strtolower($_POST['uname']);
    $password = ($_POST['upass']);
    // validate login authentication
    $query = "SELECT * FROM `tablelistowner` WHERE `email`='$email'";
    $result = $conn->query($query);


    //is user exist?
    if($result->num_rows == 0){
        echo '<script>
                    alert("User doesn'."'".'t exist. Please register a new account.");
                    window.location.href="register.html";
                </script>';
        exit();
    }

    //is user verified?
    $RESULTARRAY = $result->fetch_array(MYSQLI_ASSOC);
    if($RESULTARRAY['UID'] == "NOT VERIFIED"){
        echo '<script>
                    alert("This email is not verified yet. Please check your email.");
                    window.location.href="login.html";
                </script>';
        exit();
    }

    if($result->num_rows == 1 && $RESULTARRAY['password'] == $password){
        //login success
        $dataUser = $RESULTARRAY['email'];
        $dataUserUID = $RESULTARRAY['UID'];
        $_SESSION['email'] = $dataUser;
        $_SESSION['uid'] = $dataUserUID;
        header("Location:dashboard.php");
        exit();
    }
    else{
        $dbuserpass = $result->fetch_array(MYSQLI_ASSOC);
        //login failed
                echo '<script>
                    alert("Debug Mode echo: compare :'.$RESULTARRAY['password'].'. to this : '.$password.'");
                    window.location.href="login.html";
                </script>';
            exit();
    }
    $conn->close();

}