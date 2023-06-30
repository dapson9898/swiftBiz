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
    //creating new customer

    include('./config.php');

    if(isset($_POST['addcustomer'])) {
        $random_number = rand(1,100);
        $customer_id = "CUS00".$random_number;
        $customer_name = $_POST['customername'];
        $customer_phone = $_POST['customerphone'];

        $record = "INSERT INTO customer (id, user_id, customerid, customername, customerphone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($record);

        $stmt->bind_param("issss", $nullValue,$user_phone, $customer_id, $customer_name, $customer_phone);

        // Assign a null value to $nullvalue
        $nullValue = NULL;

        if($stmt->execute()) {
            echo "<script>alert('Customer successfully Added')</script>";
        } else {
            echo "<script>alert('Failed to Add Customer')</script>";
        }

        $stmt->close();
    }


?>

<?php
    // creating new supplier

    include('./config.php');

    if(isset($_POST['addsupplier'])) {
        $random_number = rand(1,100);
        $supplier_id = "SUP00".$random_number;
        $supplier_name = $_POST['suppliername'];
        $supplier_phone = $_POST['supplierphone'];

        $record = "INSERT INTO supplier (id, user_id, supplierid, suppliername, supplierphone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($record);

        $stmt->bind_param("issss", $nullValue, $user_phone, $supplier_id, $supplier_name, $supplier_phone);

        // Assign a null value to $nullvalue
        $nullValue = NULL;

        if($stmt->execute()) {
            echo "<script>alert('Customer successfully Added')</script>";
        } else {
            echo "<script>alert('Failed to Add Customer')</script>";
        }

        $stmt->close();
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
    <div class="option">
        <button id="customer">Add Customer</button>
        <button class="active" id="supplier">Add Supplier</button>
    </div>
    <div class="form-container customer hidden">
        <h2>Add Customer</h2>
        <form method="POST" id="add-cust">
            <div class="form">
                <label for="name">Customer name</label>
                <input type="text" placeholder="customer name" name="customername">
                <label for="phone">Phone number</label>
                <input type="text" placeholder="Phone number" name="customerphone">
            </div>
            <div class="bottom">
                <button class="cancel">Cancel</button>
                <button class="validate" name="addcustomer">Add Customer</button>
            </div>
        </form>
    </div>
    <div class="form-container supplier">
        <h2>Add Supplier</h2>
        <form method="POST" id="add-cust">
            <div class="form">
                <label for="name">Supplier name</label>
                <input type="text" placeholder="supplier name" name="suppliername">
                <label for="phone">Phone number</label>
                <input type="text" placeholder="Phone number" name="supplierphone">
            </div>
            <div class="bottom">
                <button class="cancel">Cancel</button>
                <button class="validate" name="addsupplier">Add Supplier</button>
            </div>
        </form>
    </div>
    <script>
        const customerBtn = document.querySelector('#customer');
        const supplierBtn = document.querySelector('#supplier');
        const customerDiv = document.querySelector('.customer');
        const supplierDiv = document.querySelector('.supplier');

        customerBtn.addEventListener('click', () => {
            customerDiv.classList.remove('hidden');
            customerBtn.classList.add('active');

            supplierDiv.classList.add('hidden');
            supplierBtn.classList.remove('active');
        })
        supplierBtn.addEventListener('click', () => {
            supplierDiv.classList.remove('hidden');
            supplierBtn.classList.add('active');

            customerDiv.classList.add('hidden');
            customerBtn.classList.remove('active');
        })
        

    </script>
</body>
</html>