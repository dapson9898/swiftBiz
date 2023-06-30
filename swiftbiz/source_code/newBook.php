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
    $session_number = $user_phone;

    if (isset($_POST['create'])) {
        // Check if all cashbooks have status 1
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM cashbook WHERE user_id = ? AND status = 0");
        $stmt->bind_param("s", $session_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        $stmt->close();

        // Perform actions based on the result
        if ($count > 0) {
            echo "<script>alert('You cannot create a new book until all cashbooks are closed')</script>";
        } else {
            $random_number = rand(1, 100);
            $cashbook_id = "BOOK00" . $random_number;
            $cashbook_name = $_POST['cashbookname'];
            $date_created = $_POST['datecreated'];

            $record = "INSERT INTO cashbook (count, bookid, user_id, cashbookname, createdate) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($record);

            $nullValue = NULL;
            $stmt->bind_param("issss", $nullValue, $cashbook_id, $user_phone, $cashbook_name, $date_created);

            if ($stmt->execute()) {
                echo "<script>alert('Cashbook was created successfully')</script>";
            } else {
                echo "<script>alert('Cashbook not created')</script>";
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
    <title>New Cashbook</title>
    <link rel="stylesheet" href="./form.css">
</head>
<body>
    <div class="form-container customer">
        <h2>New Cashbook</h2>
        <form method="POST">
            <div class="form">
                <label for="name">Cashbook name</label>
                <input type="text" placeholder="Cashbook name" name="cashbookname">
            </div>
            <div class="form">
                <label for="name">Date created</label>
                <input type="date" placeholder="Cashbook name" name="datecreated">
            </div>
            <div class="bottom">
                <button class="cancel">Cancel</button>
                <button type="submit" name="create">Create</button>
            </div>
        </form>
    </div>
</body>
</html>