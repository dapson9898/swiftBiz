<?php
    session_start();

    include('./config.php');

    if (isset($_POST['login'])) {
        $user_phone_number = $_POST['phone'];
        $user_password = $_POST['pass'];

        $sql = "SELECT * FROM users WHERE phone = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $user_phone_number);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];
            

            // Verify the password
            if ($user_password == $stored_password) {
                // Set session variables
               
                 $_SESSION['user_id'] = $row['id'];$_SESSION['user_phone'] = $row['phone'];
                $_SESSION['isLoggedIn'] = true;

                // Redirect to a logged-in page
                header('Location: cashbook.php');
                exit();
            } else {
                // Invalid password
                echo "<script>alert('Invalid password')</script>";
            }
        } else {
            // Invalid phone number or user not found
            echo "<script>alert('Invalid phone number or user not found')</script>";
        }

        mysqli_free_result($result);
        mysqli_close($conn);
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
            <p id="large">Welcome Back</p>
            <p>A place to keep track of your business progress</p>
            <form method="POST">
                <input type="number" placeholder="Phone Number" name="phone"/><br>
                <input type="password" placeholder="Password" name="pass"/><br>
                <div class="submit">
                    <button type="submit" name="login">Login</button>
                    <button><a href="./signup.php">Create account</a></button>
                </div>
                
            </form>
            <div class="forgot">
                <p>Forgot password?<a href="#" id="reset"> Reset</a></p>
            </div>
        </div>
    </div>
    <div class="reset-pass-back hidden">
        <div class="reset-card">
            <form>
                <input type="number" placeholder="Enter the phone number you register"/>
                <div class="submit">
                    <button id="cancel">Cancel</button>
                    <button type="submit">Sent</button>
                </div>
            </form>
        </div>
    </div>
    <script src="./forgot.js"></script>
</body>
</html>