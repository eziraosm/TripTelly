<?php
session_start();
require "dbconnect.php";
include("fn_triptelly.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotel_name = $_POST['hotel_name'];
    $hotel_address = $_POST['hotel_address'];
    $hotel_rating = $_POST['hotel_rating'];
    $hotel_price = $_POST['hotel_price'];
    $place_id = $_POST['place_id'];

    $form_data = $_SESSION['form_data'];
    $from_location = $form_data['from_loc'];
    $destination_location = $form_data['destination_loc'];
    $departure_date = date('Y-m-d', strtotime($form_data['departure_date']));  // Convert date format to MySQL format
    $return_date = date('Y-m-d', strtotime($form_data['return_date']));  // Convert date format to MySQL format
    $member = $form_data['people_num'];  // Number of people in the cart

    $cartID = generateCartID();

    $cartSql = "INSERT INTO cart (cartID, userID, fromLocation, destinationLocation, departureDate, returnDate, member)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($cartSql);
    $stmt->bind_param("ssssssi", $cartID, $_SESSION['userID'], $from_location, $destination_location, $departure_date, $return_date, $member);

    if ($stmt->execute()) {
        $_SESSION['cart_success_msg'] = "Cart inserted successfully!";
        $sql_hotel = "INSERT INTO cart_hotel (cartID, hotelID, hotelName, hotelLocation, hotelPrice)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt_hotel = $conn->prepare($sql_hotel);
        $stmt_hotel->bind_param("ssssd", $cartID, $place_id, $hotel_name, $hotel_address, $hotel_price);

        if ($stmt_hotel->execute()) {
            $_SESSION['current_cartID'] = $cartID;
            $_SESSION['success_msg'] = "Hotel added to cart successfully!";
            header("Location: searchAttractions.php");
        } else {
            $_SESSION['error_msg'] = "Error inserting hotel: " . $stmt_hotel->error;
        }
    } else {
        $_SESSION['error_msg'] = "Error inserting cart: " . $stmt->error;
    }


}
?>