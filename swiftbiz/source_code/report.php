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
    $_SESSION['page-name'] = "REPORT";
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
    <!-- Reports component -->
    <div class="report-components">
                <div class="report-nav">
                    <h4>Reports</h4>
                    <div class="credit-report">
                        <h4>Credit report</h4>
                        <a href="report.php?id=customer">
                            <div class="creditleft report">
                                <div class="img">M</div>
                                <section>
                                    <p>Customer Report</p>
                                    <button>&gt;</button>
                                </section>
                            </div>
                        </a>
                        <a href="report.php?id=supplier">
                            <div class="creditleft report">
                                <div class="img">M</div>
                                <section>
                                    <p>Supplier Report</p>
                                    <button>&gt;</button>
                                </section>
                            </div>
                        </a>
                    </div>

                    <!-- <div class="credit-report cash-book">
                        <h4>Cashbook report</h4>
                        <a href="report.php?=cashbook">
                        <div class="creditleft report">
                            <div class="img">M</div>
                            <section>
                                <p>Cashbook Report</p>
                                <button>&gt;</button>
                            </section>
                        </div>
                        </a>
                    </div> -->
                </div>
                <div class="report-body">
                   <div class="report body-top">
                    <div class="report-search">
                        <span><i class="fa-solid fa-magnifying-glass"></i></span><input type="search" placeholder="Search">
                    </div>
                    <button><span><i class="fa-solid fa-download"></i></span>Download</button>
                   </div>
                   <?php
                   include('./config.php');
                   $total_igot = 0;
                   $total_rows_igot = 0;
                   if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $session_number = $user_phone;
                        if($id == 'customer') {
                            // Fetch records based on user_phone and matchingid
                            $session_number = $user_phone;
                            $idPrefix = "CUS";

                            $stmt = $conn->prepare("SELECT * FROM igot WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igotdate ASC");
                            $stmt->bind_param("ss", $session_number, $idPrefix);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $total_rows_igot = mysqli_num_rows($result);

                            while($row = $result->fetch_assoc()) {
                                $total_igot += $row['igotamount'];
                            }
                            
                        } elseif($id == "supplier") {
                             // Fetch records based on user_phone and matchingid
                             $session_number = $user_phone;
                             $idPrefix = "SUP";
 
                             $stmt = $conn->prepare("SELECT * FROM igot WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igotdate ASC");
                             $stmt->bind_param("ss", $session_number, $idPrefix);
                             $stmt->execute();
                             $result = $stmt->get_result();
 
                             $total_rows_igot = mysqli_num_rows($result);
 
                             while($row = $result->fetch_assoc()) {
                                 $total_igot += $row['igotamount'];
                             }
                        }

                        $_SESSION['total-igot'] = $total_igot; 
                        $_SESSION['igot-rows'] = $total_rows_igot;
                    } 
                   ?>
                   <?php
                   include('./config.php');
                   $total_rows_igave = 0;
                   $total_igave = 0;
                   if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $session_number = $user_phone;
                        $name = "";
                        if($id == 'customer') {
                            // Fetch records based on user_phone and matchingid
                            $session_number = $user_phone;
                            $idPrefix = "CUS";
                            $total_igave = 0;
                            $name = "CUSTOMER REPORT";

                            $stmt = $conn->prepare("SELECT * FROM igave WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igavedate ASC");
                            $stmt->bind_param("ss", $session_number, $idPrefix);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $total_rows_igave = mysqli_num_rows($result);


                            while($row = $result->fetch_assoc()) {
                                $total_igave += $row['igaveamount'];
                            }
                            
                        } elseif ($id == "supplier"){
                            $session_number = $user_phone;
                            $idPrefix = "SUP";
                            $total_igave = 0;
                            $name = "SUPPLIER REPORT";

                            $stmt = $conn->prepare("SELECT * FROM igave WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igavedate ASC");
                            $stmt->bind_param("ss", $session_number, $idPrefix);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $total_rows_igave = mysqli_num_rows($result);


                            while($row = $result->fetch_assoc()) {
                                $total_igave += $row['igaveamount'];
                            }
                        }

                        $_SESSION['total-igave'] = $total_igave; 
                        $_SESSION['igave-rows'] = $total_rows_igave;
                        $_SESSION['name'] = $name;
                    } 
                   ?>
                   <?php
                    include('./config.php');
                    $total = 0;
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $session_number = $user_phone;
                        if($id == 'customer') {
                         
                            $sql = "SELECT * FROM customer WHERE user_id = '$session_number'";
                            $result = mysqli_query($conn, $sql);
                            $total = mysqli_num_rows($result);
                            
                        } elseif($id == "supplier"){
                            $sql = "SELECT * FROM supplier WHERE user_id = '$session_number'";
                            $result = mysqli_query($conn, $sql);
                            $total = mysqli_num_rows($result);
                        }

                        $_SESSION['people-number'] = $total;
                    } 
                   ?>

                   <div class="report body-middle">
                    <div class="balance-report">
                        <h3 style="color: #041a36;"><?php echo $_SESSION['name']; ?></h3>
                        <p>I got <span id="my-profit"><?php echo $_SESSION['total-igot']; ?>.0NGN</span></p>
                        <p>I gave <span id="my-spend"><?php echo $_SESSION['total-igave']; ?>.0NGN</span></p>
                        <h5>General balance <span id="General-balance"><?php echo $_SESSION['total-igot'] - $_SESSION['total-igave'];?></span></h5>
                    </div>
                    <div class="number-of-contacts">
                        <h5>Number of contacts: <span is="customer-number"><?php echo $_SESSION['people-number'];?></span></h5>
                        <h5>Number of transactions: <span is="transaction-number"><?php echo $_SESSION['igot-rows'] + $_SESSION['igave-rows'];?></span></h5>
                    </div>
                   </div>
                   <div class="report body-bottom" id="report-table">

                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Details</th>
                            <th>I got</th>
                            <th>I gave</th>
                        </tr>

                        <?php
                            include('./config.php');

                            $stmt = null;
                            if(isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $session_number = $user_phone;
                                if($id == 'customer') {
                                    // Fetch records from igot table based on user_phone and matchingid
                                    $idPrefix = "CUS";
                                    $stmt = $conn->prepare("SELECT * FROM igot WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igotdate ASC");
                                    $stmt->bind_param("ss", $session_number, $idPrefix);
                                    $stmt->execute();
                                    $igotResult = $stmt->get_result();
                            
                                    // Fetch records from igave table based on user_phone and matchingid
                                    $stmt = $conn->prepare("SELECT * FROM igave WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igavedate ASC");
                                    $stmt->bind_param("ss", $session_number, $idPrefix);
                                    $stmt->execute();
                                    $igaveResult = $stmt->get_result();
                            
                                    // Fetch and merge the data from both tables based on the date column
                                    $mergedResult = array_merge_recursive($igotResult->fetch_all(MYSQLI_ASSOC), $igaveResult->fetch_all(MYSQLI_ASSOC));
                            
                                    // Sort the merged result by the date column
                                    usort($mergedResult, function($a, $b) {
                                        $aDate = isset($a['igotdate']) ? $a['igotdate'] : $a['igavedate'];
                                        $bDate = isset($b['igotdate']) ? $b['igotdate'] : $b['igavedate'];
                                        return strtotime($aDate) - strtotime($bDate);
                                    });
                            
                                    // Output the merged and sorted result
                                    foreach($mergedResult as $row) {
                                        echo '<tr>';
                                        if(isset($row['igotdate'])) {
                                            echo '<td>'.$row['igotdate'].'</td>';
                                            echo '<td>'.$row['igotdetails'].'</td>';
                                            echo '<td id="igot">'.$row['igotamount'].'</td>';
                                            echo '<td id="igave"></td>';
                                        }
                                        elseif(isset($row['igavedate'])) {
                                            echo '<td>'.$row['igavedate'].'</td>';
                                            echo '<td>'.$row['igavedetails'].'</td>';
                                            echo '<td id="igot"></td>';
                                            echo '<td id="igave">'.$row['igaveamount'].'</td>';
                                        }
                                        echo '</tr>';
                                    }
                                } elseif ($id == 'supplier') {
                                        $idPrefix = "SUP";
                                        $stmt = $conn->prepare("SELECT * FROM igot WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igotdate ASC");
                                        $stmt->bind_param("ss", $session_number, $idPrefix);
                                        $stmt->execute();
                                        $igotResult = $stmt->get_result();
                                
                                        $stmt = $conn->prepare("SELECT * FROM igave WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igavedate ASC");
                                        $stmt->bind_param("ss", $session_number, $idPrefix);
                                        $stmt->execute();
                                        $igaveResult = $stmt->get_result();
                                
                                        $mergedResult = array_merge_recursive($igotResult->fetch_all(MYSQLI_ASSOC), $igaveResult->fetch_all(MYSQLI_ASSOC));
                                
                                        usort($mergedResult, function($a, $b) {
                                            $aDate = isset($a['igotdate']) ? $a['igotdate'] : $a['igavedate'];
                                            $bDate = isset($b['igotdate']) ? $b['igotdate'] : $b['igavedate'];
                                            return strtotime($aDate) - strtotime($bDate);
                                        });
                                
                                        foreach($mergedResult as $row) {
                                            echo '<tr>';
                                            if(isset($row['igotdate'])) {
                                                echo '<td>'.$row['igotdate'].'</td>';
                                                echo '<td>'.$row['igotdetails'].'</td>';
                                                echo '<td id="igot">'.$row['igotamount'].'</td>';
                                                echo '<td id="igave"></td>';
                                            }
                                            elseif(isset($row['igavedate'])) {
                                                echo '<td>'.$row['igavedate'].'</td>';
                                                echo '<td>'.$row['igavedetails'].'</td>';
                                                echo '<td id="igot"></td>';
                                                echo '<td id="igave">'.$row['igaveamount'].'</td>';
                                            }
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo "<script>alert('Invalid id')</script>";
                                    }
                            
                                }

                            if ($stmt !== null) {
                                $stmt->close();
                            }

                            $conn->close();
                        ?>


                        <!-- <tr>
                            <td>June 9 at 10:48</td>
                            <td>Blah bla blah</td>
                            <td id="igot">99.0NGN</td>
                            <td id="igave"></td>
                        </tr> -->
                    </table>
                   </div>
                </div>
        </div>
        <!--End of report component -->
    </main>
    </div>
    </body>
</html>