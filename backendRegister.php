<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    require_once 'connection.php';
    //retrieve form data
    $email = strtolower($_POST['uname']);
    $password = $_POST['upass'];
    $cpassword = $_POST['cupass'];

    //token generator
    $access_token = md5(uniqid().rand(1000000, 9999999));

    // validate login authentication
    $queryEmail = "SELECT * FROM `tablelistowner` WHERE email='$email'";
    $resultEmail = $conn->query($queryEmail);
    // compare if user already has an account
    // echo"<h1>Debuging : echo : {$result->num_rows}</h1>";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // valid address
        echo '<script>
                    alert("Your email : '.$email.' is not valid. please provide a valid email");
                    window.location.href="register.html";
                </script>';
        exit();
    }

    //check if account is taken
    if($resultEmail->num_rows == 1){
        echo '<script>
                    alert("email is already taken. select another email");
                    window.location.href="register.html";
                </script>';
        exit();
    }

    if($password != $cpassword){
        echo '<script>
                    alert("Password and Confirm does not match. Try again");
                    window.location.href="register.html";
                </script>';
        exit();
    }

    //check password length
    if(strlen($password) < 6){
        echo '<script>
                    alert("Password is too short. provide atleast 6 letters");
                    window.location.href="register.html";
                </script>';
        exit();
    }

    //Register success
    else{
        //register success

        $conn->query("INSERT INTO `tablelistowner`(`UID`, `email`, `password`) VALUES ('NEW','$email','$password')");
        echo '<script>
                    alert("Account registered! Please check your email.");
                    window.location.href="login.html";
                </script>';
        exit();
  
    }
    $conn->close();

}

?>