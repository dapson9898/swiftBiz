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

    if(isset($_POST['igot-save'])) {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $session_number = $user_phone;
            $igot_amount = $_POST['igot-amount'];
            $igot_details = $_POST['igot-details'];
            $igot_date = $_POST['igot-date'];

            $record = "INSERT INTO igot (id, matchingid, user_phone, igotamount, igotdetails, igotdate) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($record);

            $stmt->bind_param("isssss", $nullValue, $id, $session_number, $igot_amount, $igot_details, $igot_date);

            // Assign a null value to $nullValue
            $nullValue = NULL;
            
            if ($stmt->execute()) {
                echo "<script>alert('Record Added successfully')</script>";
            } else {
                echo "<script>alert('Failed to Add Record')</script>";
            }

            $stmt->close();
           
        }
        header('location: credit.php');
    }

?>
<?php
    include('./config.php');

    if(isset($_POST['igave-save'])) {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $session_number = $user_phone;

            $igave_amount = $_POST['igave-amount'];
            $igave_details = $_POST['igave-details'];
            $igave_date = $_POST['igave-date'];

            $record = "INSERT INTO igave (id, matchingid, user_phone, igaveamount, igavedetails, igavedate) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($record);

            $stmt->bind_param("isssss", $nullValue, $id,$session_number, $igave_amount, $igave_details, $igave_date);

            // Assign a null value to $nullValue
            $nullValue = NULL;
            
            if ($stmt->execute()) {
                echo "<script>alert('Record Added successfully')</script>";
            } else {
                echo "<script>alert('Failed to Add Record')</script>";
            }

            $stmt->close();
           
        }

        header('location: credit.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier and Customer</title>
    <link rel="stylesheet" href="./form.css">
</head>
<body>
<!-- echo '<a href="cashbook.php?id='.$row['bookid'].'">View Details</a>'; -->

    <div class="option">
        <button id="igot" class="active">Igot</button>
        <button id="igave">Igave</button>
    </div>
    <div class="form-container igot">
        <h2>Record money you <span class="span1">got</span></h2>
        <form method="POST" id="add-money">
            <div class="form">
                <label for="name">I got</label>
                <input type="number" placeholder="0"  name="igot-amount">
                <label for="phone">Details</label>
                <input type="text" placeholder="Details" name="igot-details">
                <label for="phone">Date</label>
                <input type="date" name="igot-date">
            </div>
            <div class="bottom">
                <button class="cancel">Cancel</button>
                <button type="submit" class="validate" name="igot-save">Save</button>
            </div>
        </form>
    </div>
    <div class="form-container igave hidden">
        <h2>Record money you <span class="span2">gave</span></h2>
        <form method="POST" id="add-money">
            <div class="form">
                <label for="name">I gave</label>
                <input type="number" placeholder="0" name="igave-amount">
                <label for="phone">Details</label>
                <input type="text" placeholder="Details" name="igave-details">
                <label for="phone">Date</label>
                <input type="date" name="igave-date">
            </div>
            <div class="bottom">
                <button class="cancel">Cancel</button>
                <button type="submit" class="validate" name="igave-save">Save</button>
            </div>
        </form>
    </div>
    <script>
        const igotBtn = document.querySelector('#igot');
        const igaveBtn = document.querySelector('#igave');
        const igotDiv = document.querySelector('.igot');
        const igaverDiv = document.querySelector('.igave');

        igotBtn.addEventListener('click', () => {
            igotDiv.classList.remove('hidden');
            igotBtn.classList.add('active');

            igaverDiv.classList.add('hidden');
            igaveBtn.classList.remove('active');
        })
        igaveBtn.addEventListener('click', () => {
            igaverDiv.classList.remove('hidden');
            igaveBtn.classList.add('active');

            igotDiv.classList.add('hidden');
            igotBtn.classList.remove('active');
        })
        

    </script>
</body>
</html>