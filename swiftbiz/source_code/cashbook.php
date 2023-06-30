<?php
    include('./config.php');

    $sq = mysqli_query($conn, "SELECT * FROM cashbook");

    $result = mysqli_num_rows($sq);
                
?>
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
    $_SESSION['page-name'] = "CASHBOOK";
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
        <div class="cashbook-components">
                    <section class="list-of-cashbook">
                    <a href="./newBook.php" style="margin-bottom: 20px; padding-bottom: 10px;">Create new cashbook</a>
                        <h3>List of Cashbooks</h3>

                        <?php
                            include('./config.php');

                            $session_number = $user_phone;

                            $sql = "SELECT * FROM cashbook WHERE user_id ='$session_number'";

                            $result = mysqli_query($conn,$sql);

                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="cash-card">';
                                echo '<div class="card-head">';
                                if($row['status'] == 0) {
                                    echo '<h5><a href="creditDebit.php?id='.$row['bookid'].'">'.$row['cashbookname'].'</a></h2>';
                                } else {
                                    echo '<h5>'.$row['cashbookname'].'</h2>';
                                }
                                echo '<a href="cashbook.php?id='.$row['bookid'].'">View Details</a>';
                                echo '<form method="POST"">';
                                if($row['status'] == 0){
                                    echo '<button type="submit" name="close-book">Close Book</button>';
                                    echo '</form>';
                                } else {
                                    echo '<button style="color: #d24e01;">Book Closed</button>';
                                }
                                echo '</div>';
                                echo '<div class="card-date">';
                                echo '<span>From: '.$row['createdate'].'</span>';
                                if($row['status'] == 0) {
                                    echo '<span>To:----------</span>';
                                } else {
                                    echo '<span>'.$row['createdate'].'</span>';
                                }
                                echo '</div>';
                                echo '</div>';
                                
                                // Check if the "Close Book" button is clicked
                                if(isset($_POST['close-book'])) {
                                    $bookid = $row['bookid'];
                                    // Update the status column in the database to 1 or true
                                    $updateQuery = "UPDATE cashbook SET status = 1 WHERE bookid = '$bookid'";
                                    mysqli_query($conn, $updateQuery);

                                    header("location: cashbook.php");

                                }
                            }
                            
                            

                        ?>

                       
                        <!-- Updating cashbook status in the database -->
                        <!-- <div class="cash-card">
                            <div class="card-head">
                                <h5><a href="#">Cashbook Name</a></h5>
                                <a href="#">Hello</a>
                                <form>
                                <button>Close Book</button>
                                </form>
                            </div>
                            <div class="card-date">
                                <span>From: 20/02/2023</span>
                                <span>To: 20/03/2023</span>
                            </div>
                        </div> -->

                    </section>
                    <section class="cashbook-container">
                        <!-- cashbook contents -->
                        <div class="query-buttons">
                            <button id="credit-btn" style="width: auto; padding: 8px;"><a href="./creditDebit.php" style="text-decoration: none; color: #fff;">Add transaction to cashbook</a></button>
                        </div>
                        <div class="cashbook-body">
                            <div class="cashbook-header">
                                <h4>Cashbook Details</h4>
                            </div>
                            <div class="cashbook-content">
                                <!-- content coming soon -->

                                <!-- fetchin the data credit-->

                                <?php
                                    if (isset($_GET['id'])) {
                                        $bookid = $_GET['id'];

                                        $sql = "SELECT * FROM cashbook JOIN credit ON cashbook.bookid = credit.id WHERE cashbook.bookid = ?";

                                        $stmt = mysqli_prepare($conn, $sql);
                                        mysqli_stmt_bind_param($stmt, "s", $bookid);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="activity">';
                                            echo '<div class="name-amount">';
                                            echo '<button>+</button>';
                                            echo '<h5>' . $row['activityname'] . '</h5>';
                                            echo '<h5 style="color: #adcf1a;">' . $row['activityamount'] . '</h5>';
                                            echo '</div>';
                                            echo '<div class="p-container">';
                                            echo '<p class="show">' . $row['activitydescription'] . '</p>';
                                            echo '</div>';
                                            echo '</div>';
                                        }

                                        mysqli_stmt_close($stmt);
                                    }
                                ?>
                                <!-- Fetching debit data -->
                                <?php
                                    if (isset($_GET['id'])) {
                                        $bookid = $_GET['id'];

                                        $sql = "SELECT * FROM cashbook JOIN debit ON cashbook.bookid = debit.id WHERE cashbook.bookid = ?";

                                        $stmt = mysqli_prepare($conn, $sql);
                                        mysqli_stmt_bind_param($stmt, "s", $bookid);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<div class="activity">';
                                            echo '<div class="name-amount">';
                                            echo '<button>+</button>';
                                            echo '<h5>' . $row['activityname'] . '</h5>';
                                            echo '<h5 style="color: #d24e01;">' . $row['activityamount'] . '</h5>';
                                            echo '</div>';
                                            echo '<div class="p-container">';
                                            echo '<p class="show">' . $row['activitydescription'] . '</p>';
                                            echo '</div>';
                                            echo '</div>';
                                        }

                                        mysqli_stmt_close($stmt);
                                    }
                                ?>


                            <!-- <div class="activity">
                                <div class="name-amount">
                                    <button>+</button>
                                    <h5>Name of activity</h5>
                                    <h5>10,000.00</h5>
                                </div>
                                <div class="p-container">
                                    <p class="show">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate ipsum quod consequuntur. Cum sint dignissimos praesentium architecto nostrum nisi facilis?</p> 
                                </div>
                            </div> -->

                        </div>
                        <div class="cashbook-footer">
                            <button><span><i class="fa-solid fa-download"></i></span>PDF</button>
                        </div>
                    </div>
                </section>
        </div>
        </main>

    </div>
    <script>
        const activityDiv = document.querySelectorAll('.activity');

        activityDiv.forEach(activity => {
            activity.addEventListener('click', () => {
                let p = activity.querySelector('.p-container');
                let btn = activity.querySelector('button');
                if(p.style.display == 'none') {
                    p.style.display = 'block';
                    btn.textContent = '-';
                } else{
                    p.style.display = 'none';
                    btn.textContent = '+';
                }
            })
        })
    
    </script>
</body>
</html>