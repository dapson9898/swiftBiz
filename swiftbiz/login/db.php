<?php
    $username = "root";
    $password = "";
    $database = "swiftbiz";


    $con = new PDO('mysql:host=localhost;dbname=swiftbiz', $username, $password) ;


    if(!$con){
        die('not connected');
    }


?>