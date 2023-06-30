<?php
include('./config.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $session_number = $user_phone;

    if ($id == 'supplier') {
        // Fetch records based on user_phone and matchingid
        $idPrefix = "SUP";
        $stmt = $conn->prepare("SELECT * FROM igot WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igotdate ASC");
        $stmt->bind_param("ss", $session_number, $idPrefix);
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.$row['igotdate'].'</td>';
            echo '<td>'.$row['igotdetails'].'</td>';
            echo '<td id="igot">'.$row['igotamount'].'</td>';
            echo '<td id="igave"></td>';
            echo '</tr>';
        }

    }

}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $session_number = $user_phone;

    if ($id == 'supplier') {
        // Fetch records based on user_phone and matchingid
        $idPrefix = "SUP";
        $stmt = $conn->prepare("SELECT * FROM igave WHERE user_phone = ? AND SUBSTRING(matchingid, 1, 3) = ? ORDER BY igavedate ASC");
        $stmt->bind_param("ss", $session_number, $idPrefix);
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.$row['igavedate'].'</td>';
            echo '<td>'.$row['igavedetails'].'</td>';
            echo '<td id="igot"></td>';
            echo '<td id="igave">'.$row['igaveamount'].'</td>';
            echo '</tr>';
        }
    }

}

?>