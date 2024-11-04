<?php
    $hostname = "localhost";
    $user = "root";
    $password = "";
    $database = "triptelly";

    $conn = mysqli_connect($hostname, $user, $password, $database) OR DIE ("Connection failed!");
?>