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

    if (isset($_POST['credit'])) {
        if (isset($_GET['id'])) {
            $bookid = $_GET['id'];
            $session_number = $user_phone;
            $date = date('d-m-Y');
            
            $credit_activity_name = $_POST['creditActivityName'];
            $credit_activity_des = $_POST['creditActivityDes'];
            $credit_activity_amount = $_POST['creditActivityAmount'];
            
            $record = "INSERT INTO credit (count, id, user_id, dates, activityname, activitydescription, activityamount) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($record);
            
            $stmt->bind_param("issssss", $nullValue, $bookid, $session_number, $date, $credit_activity_name, $credit_activity_des, $credit_activity_amount);
        
            // Assign a null value to $nullValue
            $nullValue = NULL;
        
            if ($stmt->execute()) {
                echo "<script>alert('Credit successfully Added')</script>";
            } else {
                echo "<script>alert('Failed to Add credit')</script>";
            }
        
            $stmt->close();
        }
    }

?>
<?php
    include('./config.php');

    if (isset($_POST['debit'])) {
        if (isset($_GET['id'])) {
            $bookid = $_GET['id'];
            $session_number = $user_phone;
            $date = date('d-m-Y');

            $debit_activity_name = $_POST['debitActivityName'];
            $debit_activity_des = $_POST['debitActivityDes'];
            $debit_activity_amount = $_POST['debitActivityAmount'];
            
            $record = "INSERT INTO debit (count, id, user_id, dates, activityname, activitydescription, activityamount) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($record);
            
            $stmt->bind_param("issssss", $nullValue, $bookid, $session_number, $date, $debit_activity_name, $debit_activity_des, $debit_activity_amount);
        
            // Assign a null value to $nullValue
            $nullValue = NULL;
        
            if ($stmt->execute()) {
                echo "<script>alert('Debit successfully Added')</script>";
            } else {
                echo "<script>alert('Failed to Add Debit')</script>";
            }
        
            $stmt->close();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit And Debit</title>
    <link rel="stylesheet" href="./form.css">
</head>
<body>
    <div class="option">
        <button id="credit" class="active">Credit</button>
        <button id="debit">Debit</button>
    </div>
    <div class="form-container credit">
        <h2>Add amount to Record</h2>
        <form method="POST">
            <input type="text" placeholder="Name of the activity" name="creditActivityName"/><br><br>
            <input type="text" placeholder="Description of the activity" name="creditActivityDes"/><br><br>
            <input type="number" placeholder="Amount you got" name="creditActivityAmount"/><br><br>
            <input type="submit" value="Credit" name="credit"/>
        </form>
    </div>
    <div class="form-container debit hidden">
        <h2>Add amount to Remove</h2>
        <form method="POST">
            <input type="text" placeholder="Name of the activity" name="debitActivityName"/><br><br>
            <input type="text" placeholder="Description of the activity" name="debitActivityDes"/><br><br>
            <input type="number" placeholder="Amount you got" name="debitActivityAmount"/><br><br>
            <input type="submit" value="Debit" name="debit"/>
        </form>
    </div>

    <script>
        const creditBtn = document.querySelector('#credit');
        const debitBtn = document.querySelector('#debit');
        const creditDiv = document.querySelector('.credit');
        const debitDiv = document.querySelector('.debit');

        creditBtn.addEventListener('click', () => {
            creditDiv.classList.remove('hidden');
            creditBtn.classList.add('active');

            debitDiv.classList.add('hidden');
            debitBtn.classList.remove('active');
        })
        debitBtn.addEventListener('click', () => {
            debitDiv.classList.remove('hidden');
            debitBtn.classList.add('active');

            creditDiv.classList.add('hidden');
            creditBtn.classList.remove('active');
        })
        

    </script>
</body>
</html>