<?php
session_start();
include "dbconnect.php";
include "fn_triptelly.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $place_name = $_POST['place_name'];
    $place_address = $_POST['place_address'];
    $place_rating = $_POST['place_rating'];
    $place_price = $_POST['place_price'];
    $place_id = $_POST['place_id'];

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
        $currentCartID = $row['cartID'];
    } else {
        // No existing cart, create a new one
        $form_data = $_SESSION['form_data'];
        $from_location = isset($form_data['from_loc']) ? $form_data['from_loc'] : $form_data["fromLocation"];
        $destination_location = isset($form_data['destination_loc']) ? $form_data['destination_loc'] : $form_data["destinationLocation"];
        $ddate = isset($form_data['departure_date']) ? $form_data['departure_date'] : $form_data["departureDate"];
        $departure_date = date('Y-m-d', strtotime($ddate)); // Convert date format to MySQL format
        $rdate = isset($form_data['return_date']) ? $form_data['return_date'] : $form_data["returnDate"];
        $return_date = date('Y-m-d', strtotime($rdate)); // Convert date format to MySQL format
        $member = isset($form_data['people_num']) ? $form_data['people_num'] : $form_data["member"];
        $max_budget = $form_data['max_budget'];

        $currentCartID = generateCartID();
        $cartSql = "INSERT INTO cart (cartID, userID, fromLocation, destinationLocation, departureDate, returnDate, max_budget, member)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($cartSql);
        $stmt->bind_param("ssssssdi", $currentCartID, $userID, $from_location, $destination_location, $departure_date, $return_date, $max_budget, $member);
        
        if (!$stmt->execute()) {
            $_SESSION['error_msg'] = "Error creating cart: " . $stmt->error;
            header("Location: errorPage.php");
            exit;
        }

        // Save the new cart ID for this session
        $_SESSION['cartID'] = $currentCartID;
    }

    // Insert attraction into the cart
    $attSql = "INSERT INTO cart_attractions (cartID, attID, attName, attLocation, attPrice)
               VALUES (?, ?, ?, ?, ?)";
    $stmt_att = $conn->prepare($attSql);
    $stmt_att->bind_param("ssssd", $currentCartID, $place_id, $place_name, $place_address, $place_price);

    if ($stmt_att->execute()) {
        $_SESSION['success_msg'] = $place_name . " added to cart successfully!";
        header("Location: searchAttractions.php");
    } else {
        $_SESSION['error_msg'] = "Error inserting attraction: " . $stmt_att->error;
        header("Location: errorPage.php");
    }
}
?>
