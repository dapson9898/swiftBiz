<?php
    // Check if the user is logged in
    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
        // Redirect to the login page if not logged in
        header('Location: login.php');
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $user_phone = $_SESSION['user_phone'];

?>

<header>
    <div class="heading">
        <h4><?php echo $_SESSION['page-name']?></h4>
    </div>
    <div class="months">
        <select>
            <option>month</option>
            <option>January</option>
            <option>February</option>
            <option>March</option>
            <option>April</option>
            <option>May</option>
            <option>June</option>
        </select>
    </div>
    <div class="users">
        <div>
            <h6><?php echo $user_phone ?></h6>
            <small>Online</small>
        </div>
        <img src="../assets/profile-8.jpg"/>
    </div>
</header>