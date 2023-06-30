<?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
        // Redirect to the login page if not logged in
        header('Location: index.php');
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $user_phone = $_SESSION['user_phone'];


?>
<?php

    include('./config.php');

    if(isset($_POST['submit'])) {
        $session_number = $user_phone;
        $id = $_POST['id'];
        $user_id = $session_number;
        $username = $_POST['username'];
        $business_name = $_POST['business-name'];
        $business_category = $_POST['business-category'];
        $business_type = $_POST['business-type'];
        $business_address = $_POST['business-address'];
        $business_city = $_POST['business-city'];

        // UPDATE `account` SET `business_category` = 'Servicess' WHERE `account`.`id` = 1

        // $record = "INSERT INTO account (id, user_id, username, business_name, business_category, business_type, business_address, business_city) VALUE (?, ?, ?, ?, ?, ?, ?, ?)";
        $record = "UPDATE account SET  username =?, business_name =?, business_category =?, business_type =?, business_address =?, business_city =?  WHERE user_id= '$user_id'";
        $stmt = $conn->prepare($record);
        $stmt->execute(array($username, $business_name, $business_category, $business_type, $business_address, $business_city));

        // $stmt->bind_param("isssssss", $nullValue, $session_number, $username, $business_name, $business_category, $business_type, $business_address, $business_city);

        $nullValue = NULL;

        if ($stmt) {
            echo "<script>alert('Information updated successfully')</script>";
        } else {
            echo "<script>alert('Failed to update record')</script>";
        }

        $stmt->close();
    }
?>
<?php
    $_SESSION['page-name'] = "ACCOUNT";
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
    <link rel="stylesheet" href="./style.css">  
</head>
<body>
    <div class="container">
    <?php include('./aside.php')?>
    <main>
    <?php include('./header.php')?>
    <div class="account-component">
                <div class="account-form">
                    <h4>My information</h4>
                    <form method="POST">
                        <table>
                            <?php
                                include('./config.php');
                                $session_number = $user_phone;
                                $sql = "SELECT * FROM account WHERE user_id = '$session_number'";
                                $result = mysqli_query($conn, $sql);

                                while($row = mysqli_fetch_assoc($result)){
                                   

                                
                            ?>
                            <tr>
                                <td>Phone Number</td>
                                <td>Name</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" value="<?php echo '+234'.$user_phone; ?>" readonly>
                                    <input type="text" name="id" value ="<?php echo $row['id']; ?>" style= "display : none">
                                </td>
                                <td>
                                    <input type="text" placeholder="Add your name" value="<?php echo $row['username']; ?>"  name="username">
                                </td>
                            </tr>
                            <tr>
                                <td>Business Name</td>
                                <td>Business Category</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" placeholder="Insert Business name" value="<?php echo $row['business_name']; ?>" name="business-name">
                                </td>
                                <td>
                                    <select name="business-category">
                                        <option><?php echo $row['business_category']; ?></option>
                                        <option>Shop</option>
                                        <option>Wholeseler</option>
                                        <option>Distributor</option>
                                        <option>Fabrication</option>
                                        <option>Services</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Business type</td>
                                <td>Address</td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="business-type" ?>">
                                        <option><?php echo $row['business_type']; ?></option>
                                        <option><h5>Retails</h5></option>
                                        <option>Groceries</option>
                                        <option>Electronics and home appliance</option>
                                        <option>Clothes and fashion</option>
                                        <option>Bookstores</option>
                                        <option>Jewelry</option>
                                        <option>Cosmetics</option>
                                        <option>Tools and hardware store</option>
                                        <option>Construction materials</option>
                                        <option>Car parts</option>
                                        <option>Gas station</option>
                                        <option>Agricultural products</option>
                                        <option>Fruit snd veggles store</option>
                                        <option>Fish shop</option>
                                        <option>Bakery</option>
                                        <option><h5>Services</h5></option>
                                        <option>Professional services</option>
                                        <option>Transportation &amp; logistics</option>
                                        <option>Real Estate</option>
                                        <option>Medical services</option>
                                        <option>Car rental &amp; repair</option>
                                        <option>Insurance</option>
                                        <option>Other Services</option>
                                        <option><h5>Mobile &amp; Technology</h5></option>
                                        <option>Electronics</option>
                                        <option>Mobile recharge, internet and financial services</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" placeholder="Add your Address" value="<?php echo $row['business_address']; ?>" name="business-address">
                                </td>
                            </tr>
                            <tr>
                                <td>City</td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" placeholder="Add your City" value="<?php echo $row['business_city']; ?>" name="business-city">
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <div class="update-btn hidden">
                                    <td><button>Cancel</button></td>
                                    <td><button class="update-btn" type="submit" name="submit">Update infor</button></td>
                                </div>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <!--End od account component -->
    </main>
    </div>
            <script src="./app.js"></script>
            <script>
                const submit_container = document.querySelector('.update-btn');
                const input_fields = document.querySelectorAll('input');
                const select_fields = document.querySelectorAll('select');

                input_fields.forEach(input_field => {
                    input_field.addEventListener('keyup', () => {
                        
                    })
                })
                select_fields.forEach(select_field => {
                    select_field.addEventListener('click', () => {
                        
                    })
                })
            </script>
    </body>
</html>