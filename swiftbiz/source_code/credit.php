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
    $_SESSION['page-name'] = "CREDITBOOK";
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
    <div class="backdrop"></div>
    <div class="container">
    <?php include('./aside.php')?>
    <main>
    <?php include('./header.php')?>
    <!-- Credit book component -->
    <div class="creditbook-components">
                <h3><?php echo '+234'.$user_phone;?></h3>
                <section class="section">
                    <section class="list-of-creditbook">
                        <div class="credit-sec1">
                            <button class="customer active" id="customer-btn">Customers</button>
                            <button class="supplier" id="supplier-btn">Suppliers</button>
                        </div>
                        <div class="credit-sec2">
                            <h4>3 Customers</h4>
                            <div class="buttons">
                                <button class="pdf"><i class="fa-solid fa-file-pdf"></i></button>
                                <button class="add" title="Add supplier or customer"><a href="./addSupplierCustomer.php" style="text-decoration: none; color: #fff;"><i class="fa-solid fa-user-plus"></i></a></button>
                            </div>
                        </div>
                        <div class="credit-sec3">
                            <?php
                                include('./config.php');
                                $session_number = $user_phone;
                                $total_igot = 0;
                                $sql = "SELECT * FROM igot WHERE user_phone = '$session_number'";
                                $result = mysqli_query($conn, $sql);

                                while($row = mysqli_fetch_assoc($result)) {
                                    $total_igot += $row['igotamount'];
                                }

                                $_SESSION['total-igot'] = $total_igot;

                            ?>
                            <?php
                                include('./config.php');
                                $session_number = $user_phone;
                                $total_igave = 0;
                                $sql = "SELECT * FROM igave WHERE user_phone = '$session_number'";
                                $result = mysqli_query($conn, $sql);

                                while($row = mysqli_fetch_assoc($result)) {
                                    $total_igave += $row['igaveamount'];
                                }

                                $_SESSION['total-igave'] = $total_igave;

                            ?>
                            <div class="sec-top">
                                <div class="sec-left">
                                    <p>I got</p>
                                    <p style="color: #adcf1a;"><?php echo $_SESSION['total-igot'];?></p>
                                </div>
                                <div class="sec-right">
                                    <p>I gave</p>
                                    <p style="color: #d24e01;"><?php echo $_SESSION['total-igave'];?></p>
                                </div>
                            </div>
                            <div class="sec-but">
                                <div class="search-bar"><span><i class="fa-solid fa-magnifying-glass"></i></span><input type="search" placeholder="Search"></div>
                                <button id="filter"><i class="fa-solid fa-sort"></i></button>
                                <div class="filter hidden">
                                    <div class="filter-head">
                                        <h3>Filter</h3>
                                        <button id="close-filter">close</button>
                                    </div>
                                    <div class="sort-by-sub-one">
                                        <button class="active">All</button>
                                        <button>Got</button>
                                        <button>Gave</button>
                                        <button>Settled</button>
                                    </div>
                                    <div class="sort-by-sub-two">
                                        <input type="radio" name="sort"/> <small>Recent</small><br>
                                        <input type="radio" name="sort"/> <small>Oldest</small><br>
                                        <input type="radio" name="sort"/> <small>Highest Amount</small><br>
                                        <input type="radio" name="sort"/> <small>least Amount</small><br>
                                        <input type="radio" name="sort"/> <small>By Name (A-Z)</small><br>
                                    </div>
                                    <div class="sort-btn">
                                        <button>cancel</button>
                                        <button class="sort">Sort</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Calculation for customers -->
                        <?php
                            // igot money
                            include('./config.php');
                            
                            $totalAmountGain = null;
                            $totalAmountDebit = null;
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];

                                $sql = "SELECT * FROM customer JOIN igot ON customer.customerid = igot.matchingid WHERE customer.customerid = ?";

                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "s", $id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                $totalAmountGain = 0;

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $amount = $row['igotamount'];
                                    $totalAmountGain += $amount;
                                }

                                mysqli_free_result($result);
                                mysqli_stmt_close($stmt);
                            }

                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];

                                $sql = "SELECT * FROM customer JOIN igave ON customer.customerid = igave.matchingid WHERE customer.customerid = ?";

                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "s", $id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                $totalAmountDebit = 0;

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $amount = $row['igaveamount'];
                                    $totalAmountDebit += $amount;
                                }

                                mysqli_free_result($result);
                                mysqli_stmt_close($stmt);
                            }

                            $return_amount_customer = $totalAmountGain - $totalAmountDebit;

                            $_SESSION['return_amount_customer'] = $return_amount_customer;

                        ?>



                        <div class="credit-sec4" id="demand">
                            <?php
                                include('./config.php');

                                $session_number = $user_phone;

                                $sql = "SELECT * FROM customer WHERE user_id = '$session_number'";
                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $customerId = $row['customerid'];

                                    // Fetch the total igot amount for this customer
                                    $igotSql = "SELECT SUM(igotamount) AS total_amount FROM igot WHERE matchingid = ?";
                                    $igotStmt = mysqli_prepare($conn, $igotSql);
                                    mysqli_stmt_bind_param($igotStmt, "s", $customerId);
                                    mysqli_stmt_execute($igotStmt);
                                    $igotResult = mysqli_stmt_get_result($igotStmt);
                                    $igotRow = mysqli_fetch_assoc($igotResult);
                                    $totalAmountGain = $igotRow['total_amount'];

                                    // Fetch the total igave amount for this customer
                                    $igaveSql = "SELECT SUM(igaveamount) AS total_amount FROM igave WHERE matchingid = ?";
                                    $igaveStmt = mysqli_prepare($conn, $igaveSql);
                                    mysqli_stmt_bind_param($igaveStmt, "s", $customerId);
                                    mysqli_stmt_execute($igaveStmt);
                                    $igaveResult = mysqli_stmt_get_result($igaveStmt);
                                    $igaveRow = mysqli_fetch_assoc($igaveResult);
                                    $totalAmountDebit = $igaveRow['total_amount'];

                                    // Calculate the return amount for this customer
                                    $returnAmountCustomer = $totalAmountGain - $totalAmountDebit;

                                    echo '<a href="credit.php?id=' . $row['customerid'] . '">';
                                    echo '<div class="credit">';
                                    echo '<div class="creditleft" style="width: 80%;">';
                                    echo '<div class="img">M</div>';
                                    echo '<section>';
                                    echo '<p>' . $row['customername'] . '</p>';
                                    echo '<small>';
                                    echo '<a href="igotAndIgave.php?id=' . $row['customerid'] . '">Add record</a>';
                                    echo '</small>';
                                    echo '</section>';
                                    echo '</div>';
                                    echo '<div class="creditright">';
                                    if ($returnAmountCustomer < 0) {
                                        echo '<p style="color: #d24e01;">' . abs($returnAmountCustomer) . '</p>';
                                        echo '<small style="color: #d24e01;">i gave</small>';
                                    } else {
                                        echo '<p style="color: #adcf1a;">' . $returnAmountCustomer . '</p>';
                                        echo '<small style="color: #adcf1a;">i got</small>';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</a>';
                                }
                            ?>

                            <!-- <a href="#">
                            <div class="credit">
                                <div class="creditleft" style="width: 80%;">
                                    <div class="img">M</div>
                                    <section>
                                        <p>Emjay Tanko</p>
                                        <small><a href="#" style="font-size: 13px;">Add record</a></small>
                                    </section>
                                </div>
                                <div class="creditright">
                                    <p>N 3000</p>
                                    <small>I got</small>
                                </div>
                            </div>
                            </a> -->

                        </div>

                        <!-- Fetching supplier money cummulative -->
                        <?php
                            // igot money
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];

                                $sql = "SELECT * FROM supplier JOIN igot ON supplier.supplierid = igot.matchingid WHERE supplier.supplierid = ?";

                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "s", $id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                $totalAmountGain = 0;

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $amount = $row['igotamount'];
                                    $totalAmountGain += $amount;
                                }

                                mysqli_free_result($result);
                                mysqli_stmt_close($stmt);
                            }

                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];

                                $sql = "SELECT * FROM supplier JOIN igave ON supplier.supplierid = igave.matchingid WHERE supplier.supplierid = ?";

                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "s", $id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                $totalAmountDebit = 0;

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $amount = $row['igaveamount'];
                                    $totalAmountDebit += $amount;
                                }

                                mysqli_free_result($result);
                                mysqli_stmt_close($stmt);
                            }

                            $return_amount_supplier = $totalAmountGain - $totalAmountDebit;

                            $_SESSION['return_amount_supplier'] = $return_amount_supplier;

                        ?>


                        <!-- Supplier list -->
                        <div class="credit-sec4 hidden" id="supplying">
                        <?php
                            include('./config.php');

                            $session_number = $user_phone;

                            $sql = "SELECT * FROM supplier WHERE user_id = '$session_number'";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $supplierId = $row['supplierid'];

                                // Fetch the total igot amount for this supplier
                                $igotSql = "SELECT SUM(igotamount) AS total_amount FROM igot WHERE matchingid = ?";
                                $igotStmt = mysqli_prepare($conn, $igotSql);
                                mysqli_stmt_bind_param($igotStmt, "s", $supplierId);
                                mysqli_stmt_execute($igotStmt);
                                $igotResult = mysqli_stmt_get_result($igotStmt);
                                $igotRow = mysqli_fetch_assoc($igotResult);
                                $totalAmountGain = $igotRow['total_amount'];

                                // Fetch the total igave amount for this supplier
                                $igaveSql = "SELECT SUM(igaveamount) AS total_amount FROM igave WHERE matchingid = ?";
                                $igaveStmt = mysqli_prepare($conn, $igaveSql);
                                mysqli_stmt_bind_param($igaveStmt, "s", $supplierId);
                                mysqli_stmt_execute($igaveStmt);
                                $igaveResult = mysqli_stmt_get_result($igaveStmt);
                                $igaveRow = mysqli_fetch_assoc($igaveResult);
                                $totalAmountDebit = $igaveRow['total_amount'];

                                // Calculate the return amount for this supplier
                                $returnAmountSupplier = $totalAmountGain - $totalAmountDebit;

                                echo '<a href="credit.php?id=' . $row['supplierid'] . '">';
                                echo '<div class="credit">';
                                echo '<div class="creditleft" style="width: 80%;">';
                                echo '<div class="img">M</div>';
                                echo '<section>';
                                echo '<p>' . $row['suppliername'] . '</p>';
                                echo '<small>';
                                echo '<a href="igotAndIgave.php?id=' . $row['supplierid'] . '">Add record</a>';
                                echo '</small>';
                                echo '</section>';
                                echo '</div>';
                                echo '<div class="creditright">';
                                if ($returnAmountSupplier < 0) {
                                    echo '<p style="color: #d24e01;">' . abs($returnAmountSupplier) . '</p>';
                                    echo '<small style="color: #d24e01;">i gave</small>';
                                } else {
                                    echo '<p style="color: #adcf1a;">' . $returnAmountSupplier . '</p>';
                                    echo '<small style="color: #adcf1a;">i got</small>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</a>';
                            }
                            ?>

                        </div>
                    </section>
    
                    <section class="activity-creditbook">
                        <div class="details">
                            <div class="detail1">
                                <p><span id="current-client"></span></p>
                                <small>View contact detail <span></span></small>
                            </div>
                            <div class="detail2">
                                <button id="calenderBtn"><span><i class="fa-solid fa-calendar-days"></i></span>All<span><i class="fa-solid fa-angle-up"></i></span></button>
                                <button><span><i class="fa-solid fa-download"></i></span>Download</button>
                                <div class="calender hidden" id="calender">
                                    <div class="calender-header">
                                        <button id="prevBtn">Prev</button>
                                        <h2 id="month-and-year"></h2>
                                        <button id="nex-btn">Next</button>
                                    </div>
                                    <div class="weekdays">
                                        <div>Sun</div>
                                        <div>Mon</div>
                                        <div>Tue</div>
                                        <div>Wed</div>
                                        <div>Thu</div>
                                        <div>Fri</div>
                                        <div>Sat</div>
                                    </div>
                                    <div class="days"></div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="bal">
                            <div class="bal1">
                                <p>Balance</p>
                                <span>N 5 000</span>
                            </div>
                            <div class="bal2">
                                <div class="summ">
                                    <p>I got N<span>13 000</span></p>
                                    <p>I gave N<span>13 000</span></p>
                                </div>
                                <div class="butt">
                                    <button><a href="./igotAndIgave.php" style="text-decoration: none; color: #fff;">Record Transaction</a></button>
                                </div>
                            </div>
                        </div> -->
                        <div class="transactions">
                            <p>Transactions</p>
                            <div class="trans-list">

                                <?php
                                
                                    if(isset($_GET['id'])) {
                                        $id = $_GET['id'];

                                        

                                        $sql = "SELECT * FROM supplier JOIN igot ON supplier.supplierid = igot.matchingid WHERE supplier.supplierid = ?";

                                        $stmt = mysqli_prepare($conn, $sql);
                                        mysqli_stmt_bind_param($stmt, "s", $id);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        $igot_rows = mysqli_num_rows($result);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="trans">';
                                            echo '<div class="transleft">';
                                            echo '<div class="img">';
                                            echo '<span>';
                                            echo '<i class="fa-solid fa-arrow-up"></i>';
                                            echo '</span>';
                                            echo '</div>';
                                            echo '<section>';
                                            echo '<p>'.$row['igotdetails'].'</P>';
                                            echo '<small>'.$row['igotdate'].'</small>';
                                            echo '</section>';
                                            echo '</div>';
                                            echo '<div class="transright">';
                                            echo '<p>N'.$row['igotamount'].'</p>';
                                            echo '<small>I got</small>';
                                            echo '</div>';
                                            echo '</div>';

                                        }
                                        
                                        mysqli_stmt_close($stmt);
                                    }

                                ?>


                                <?php
                                
                                    if(isset($_GET['id'])) {
                                        $id = $_GET['id'];


                                        $sql = "SELECT * FROM supplier JOIN igave ON supplier.supplierid = igave.matchingid WHERE supplier.supplierid = ?";

                                        $stmt = mysqli_prepare($conn, $sql);
                                        mysqli_stmt_bind_param($stmt, "s", $id);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        $igave_rows = mysqli_num_rows($result);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="trans">';
                                            echo '<div class="transleft">';
                                            echo '<div class="img">';
                                            echo '<span>';
                                            echo '<i class="fa-solid fa-arrow-down"></i>';
                                            echo '</span>';
                                            echo '</div>';
                                            echo '<section>';
                                            echo '<p>'.$row['igavedetails'].'</P>';
                                            echo '<small>'.$row['igavedate'].'</small>';
                                            echo '</section>';
                                            echo '</div>';
                                            echo '<div class="transright">';
                                            echo '<p style="color: #d24e01;">N'.$row['igaveamount'].'</p>';
                                            echo '<small style="color: #d24e01;">I gave</small>';
                                            echo '</div>';
                                            echo '</div>';
                                            
                                        }
                                            
                                        mysqli_stmt_close($stmt);
                                    }
                    
                                ?>

                                <?php
                                
                                    if(isset($_GET['id'])) {
                                        $id = $_GET['id'];

                                        

                                        $sql = "SELECT * FROM customer JOIN igot ON customer.customerid = igot.matchingid WHERE customer.customerid = ?";

                                        $stmt = mysqli_prepare($conn, $sql);
                                        mysqli_stmt_bind_param($stmt, "s", $id);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        $igot_rows = mysqli_num_rows($result);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="trans">';
                                            echo '<div class="transleft">';
                                            echo '<div class="img">';
                                            echo '<span>';
                                            echo '<i class="fa-solid fa-arrow-up"></i>';
                                            echo '</span>';
                                            echo '</div>';
                                            echo '<section>';
                                            echo '<p>'.$row['igotdetails'].'</P>';
                                            echo '<small>'.$row['igotdate'].'</small>';
                                            echo '</section>';
                                            echo '</div>';
                                            echo '<div class="transright">';
                                            echo '<p>N'.$row['igotamount'].'</p>';
                                            echo '<small>I got</small>';
                                            echo '</div>';
                                            echo '</div>';

                                        }
                                        
                                        mysqli_stmt_close($stmt);
                                    }

                                ?>

                                <?php
                                
                                    if(isset($_GET['id'])) {
                                        $id = $_GET['id'];


                                        $sql = "SELECT * FROM customer JOIN igave ON customer.customerid = igave.matchingid WHERE customer.customerid = ?";

                                        $stmt = mysqli_prepare($conn, $sql);
                                        mysqli_stmt_bind_param($stmt, "s", $id);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        $igave_rows = mysqli_num_rows($result);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="trans">';
                                            echo '<div class="transleft">';
                                            echo '<div class="img">';
                                            echo '<span>';
                                            echo '<i class="fa-solid fa-arrow-down"></i>';
                                            echo '</span>';
                                            echo '</div>';
                                            echo '<section>';
                                            echo '<p>'.$row['igavedetails'].'</P>';
                                            echo '<small>'.$row['igavedate'].'</small>';
                                            echo '</section>';
                                            echo '</div>';
                                            echo '<div class="transright">';
                                            echo '<p style="color: #d24e01;">N'.$row['igaveamount'].'</p>';
                                            echo '<small style="color: #d24e01;">I gave</small>';
                                            echo '</div>';
                                            echo '</div>';
                                            
                                        }
                                            
                                        mysqli_stmt_close($stmt);
                                    }
                    
                                ?>
                                
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        <!-- End of Credit book component -->
    </main>
    </div>
    <script src="./app.js"></script>
    <script>
        const customerBtn2 = document.querySelector('#customer-btn');
        const supplierBtn2 = document.querySelector('#supplier-btn');
        const customerDiv = document.querySelector('#demand');
        const supplierDiv = document.querySelector('#supplying');

        customerBtn2.addEventListener('click', () => {
            customerDiv.classList.remove('hidden');
            customerBtn2.classList.add('active');

            supplierDiv.classList.add('hidden');
            supplierBtn2.classList.remove('active');

        });

        supplierBtn2.addEventListener('click', () => {
            supplierDiv.classList.remove('hidden');
            supplierBtn2.classList.add('active');

            customerDiv.classList.add('hidden');
            customerBtn2.classList.remove('active');

        });
    </script>
</body>
</htm>