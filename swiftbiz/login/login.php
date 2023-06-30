<?php
    require 'db.php';
    
    if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $sql = "INSERT INTO `login` (`username`, `PASSWORD`) VALUES ('$username','$password')";
    $con->exec($sql);
    
    print("success");

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <link rel="stylesheet" href="./login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <script src="https://kit.fontawesome.com/cecfb861f7.js" crossorigin="anonymous"></script>
    <script src="login.js" defer></script>
    
</head>

<style>
    #backdrop{
        display: none;
    }
</style>
<body>
    <div id="backdrop">
    </div>
        <div class="forgot-password">
            <button>X</button>
            <h4>Reset password</h4>
            <form action="">
                <input type="email" class="id" name="username"
                 placeholder="Enter your email address..">
                <br>
                <input type="submit" name=" value="Submit">
            </form>
            <p></p>
        </div>
    <header>
        <div class="logo">
            <h1>SWIFT <span class="span1">BIZ</span><span class="span2"></span></h1>
        </div>
    </header>
    <section class="home">
        <div class="left-section">
            <h4>world class control</h4>
            <h1>Become <br>a professional in<br> either field.</h1>
            <p>Swift biz has helped to provide skills for jobs relevant to the market<br>for over 100s businesses for individuals and companies.</p>
            <a href="../source code/index.html">Checkout our website</a>
        </div>
        <div class="right-section">
            
            <div class="form">
                <div class="form-card staff">
                    <h4>Sign in</h4>
                    <form  method="POST">
                        <input type="text" placeholder="ID number..." name="username" /><br><br>
                        <input type="password" placeholder="password..." name="password" /><br><br>
                        <input type="submit" name="submit" value="Submit"/>
                    </form>
                    <p>Forgot password? <a href="#">Reset</a></p>
                </div>
                
            </div>
        </div>
    </section>
    
    <footer>
        <div class="logo">
            <h1>Swift <span class="span1">biz</span><span class="span2"></span></h1>
            <p>Federal University Kashere<br> Hotels Gombe, Gombe state Nigeria.</p>
        </div>
        <div>
            <p>&copy;pen college 2023.</p>
        </div>
    </footer>
</body>
</html>