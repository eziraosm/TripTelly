<?php
session_start();
include "dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $place_name = $_POST['place_name'];
    $place_address = $_POST['place_address'];
    $place_rating = $_POST['place_rating'];
    $place_price = $_POST['place_price'];
    $place_id = $_POST['place_id'];

    $currentCartID = $_SESSION['current_cartID'];

    $attSql = "INSERT INTO cart_attractions (cartID, attID, attName, attLocation, attPrice)
                    VALUES (?, ?, ?, ?, ?)";
    
    $stmt_att = $conn -> prepare($attSql);
    $stmt_att -> bind_param("ssssd", $currentCartID, $place_id, $place_name, $place_address, $place_price);

    if ($stmt_att -> execute()) {
        $_SESSION['success_msg'] = "Attraction added to cart successfully!";
        header("Location: searchAttractions.php");
    }
}

?>