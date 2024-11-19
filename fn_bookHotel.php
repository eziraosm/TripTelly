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
    $from_location = isset($form_data['from_loc']) ? $form_data['from_loc'] : $form_data["fromLocation"];
    $destination_location = isset($form_data['destination_loc']) ? $form_data['destination_loc'] : $form_data["destinationLocation"];
    $ddate = isset($form_data['departure_date']) ? $form_data['departure_date'] : $form_data["departureDate"];
    $departure_date = date('Y-m-d', strtotime($ddate));  // Convert date format to MySQL format
    $rdate = isset($form_data['return_date']) ? $form_data['return_date'] : $form_data["returnDate"];
    $return_date = date('Y-m-d', strtotime($rdate));  // Convert date format to MySQL format
    $member = isset($form_data['people_num']) ? $form_data['people_num'] : $form_data["member"];
    $max_budget = $form_data['max_budget'];

    // Check if user already has an existing cart
    $userID = $_SESSION['userID'];
    $existingCartQuery = "SELECT cartID FROM cart WHERE userID = ?";
    $stmt = $conn->prepare($existingCartQuery);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Reuse existing cartID
        $row = $result->fetch_assoc();
        $cartID = $row['cartID'];
    } else {
        // No existing cart, create a new one
        $cartID = generateCartID();
        $cartSql = "INSERT INTO cart (cartID, userID, fromLocation, destinationLocation, departureDate, returnDate, max_budget, member)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($cartSql);
        $stmt->bind_param("ssssssdi", $cartID, $userID, $from_location, $destination_location, $departure_date, $return_date, $max_budget, $member);
        
        if (!$stmt->execute()) {
            $_SESSION['error_msg'] = "Error inserting cart: " . $stmt->error;
            header("Location: errorPage.php");
            exit;
        }
    }

    // Insert hotel into the cart
    $sql_hotel = "INSERT INTO cart_hotel (cartID, hotelID, hotelName, hotelLocation, hotelPrice)
                  VALUES (?, ?, ?, ?, ?)";
    $stmt_hotel = $conn->prepare($sql_hotel);
    $stmt_hotel->bind_param("ssssd", $cartID, $place_id, $hotel_name, $hotel_address, $hotel_price);

    if ($stmt_hotel->execute()) {
        $_SESSION['cartID'] = $cartID;
        $_SESSION['success_msg'] = "Hotel added to cart successfully!";
        header("Location: searchAttractions.php");
    } else {
        $_SESSION['error_msg'] = "Error inserting hotel: " . $stmt_hotel->error;
        header("Location: errorPage.php");
    }
}
?>
