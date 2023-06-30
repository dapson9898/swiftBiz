<?php
    include('config.php');
    if(isset($_POST['submit'])) {
        
        $phone_number = $_POST['phone'];
        $password = $_POST['pass'];
        $confirm_pass = $_POST['confirm-pass'];

        if($password !== $confirm_pass) {
            echo "<script>alert('Password and confirm password not thesame')</script>";
        } else {
            $sql = "INSERT INTO users (id,phone,password,cpassword) VALUES (NULL,$phone_number,$password,$confirm_pass)";

            $insertion = mysqli_query($conn, $sql);
            echo "<script>alert('Registration Successfull')</script>";
        }
        // header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwiftBiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <script src="https://kit.fontawesome.com/cecfb861f7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./index.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>SWIFT<span>BIZ</span></h1>
            <small>A home for small and large Business</small>
        </div>
    </header>
    <div class="container">
        <div class="left-container">
            <img src="../assets/business-goal.svg"/>
        </div>
        <div class="right-container">
            <p id="large">Sign up here</p>
            <p>A place to keep track of your business progress</p>
            <form method="POST">
                <input type="number" placeholder="Phone Number" name="phone"/><br>
                <input type="password" placeholder="Password" name="pass"/><br>
                <input type="password" placeholder="Confirm Password" name="confirm-pass"/><br>
                <div class="submit">
                    <button><a href="./index.php" >Back to login</a></button>
                    <button type="submit" name="submit">Create account</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>