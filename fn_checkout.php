<?php
session_start();
require "dbconnect.php";

if(!isset($_GET['cartID'])  || $_GET['cartID'] == null || $_GET['cartID'] == '') {
    $_SESSION['error_msg'] = "Cart is empty";
    header("Location: cart.php");
    exit;
}

$totalPrice = '';

if (isset($_GET['cartID'])) {
    $cartID = $_GET['cartID'];
    $userID = $_SESSION['userID'];

    // get cart data 
    $cartSQL = 'SELECT * FROM cart WHERE cartID = ? AND userID = ?';
    $cartStmt = $conn->prepare($cartSQL);
    if ($cartStmt) {
        // Use bind_param for mysqli
        $cartStmt->bind_param('ss', $cartID, $userID); // 'ss' indicates two string parameters
        $cartStmt->execute();
        $cartResult = $cartStmt->get_result();
        $cartRow = $cartResult->fetch_assoc();
        
    } else {
        $_SESSION['error_msg'] = "Error in statement preparation: " . $conn->error;
        header("Location: cart.php");
        exit;
    }

    //get data hotel
    $hotelSQL = 'SELECT * FROM cart_hotel WHERE cartID = ?';
    $hotelStmt = $conn->prepare($hotelSQL);
    if ($hotelStmt) {
        $hotelStmt->bind_param('s', $cartID);
        $hotelStmt->execute();
        $hotelResult = $hotelStmt->get_result();    
        $hotelRow = $hotelResult->fetch_assoc();
    } else {
        $_SESSION['error_msg'] = "Error in statement preparation: " . $conn->error;
        header("Location: cart.php");
        exit;
    }

    // get att data
    $attSQL = 'SELECT * FROM cart_attractions WHERE cartID = ?';
    $attStmt = $conn->prepare($attSQL);
    if ($attStmt) {
        $attStmt->bind_param('s', $cartID);
        $attStmt->execute();
        $attResult = $attStmt->get_result();    
        $attArray = [];
        while ($attRow = $attResult->fetch_assoc()) {
            $attArray[] = $attRow;
        }
    } else {
        $_SESSION['error_msg'] = "Error in statement preparation: " . $conn->error;
        header("Location: cart.php");
        exit;
    }

    // convert hotelRow into JSON
    $hotelJson = json_encode($hotelRow);

    // convert attArray into JSON
    $attJson = json_encode($attArray);

    // prepare all data to insert into payment table
    if (isset($_SESSION['totalPrice'])) {
        $totalPrice = $_SESSION['totalPrice'];
        unset($_SESSION['totalPrice']);
    }
    $fromLocation = $cartRow['fromLocation'];
    $destLocation = $cartRow['destinationLocation'];
    $departDate = date('Y-m-d', strtotime($cartRow['departureDate']));
    $returnDate = date('Y-m-d', strtotime($cartRow['returnDate']));
    $person = $cartRow['member'];
    $max_budget = $cartRow['max_budget'];
    $paymentDate = date("Y-m-d H:i:s");


    // Prepare the SQL query to insert data into the payment table
    $paymentSQL = "INSERT INTO payment (cartID, userID, hotelData, placeData, totalPrice, fromLocation, destinationLocation, departureDate, returnDate, person, max_budget) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $paymentStmt = $conn->prepare($paymentSQL);

    // Check if the statement was successfully prepared
    if ($paymentStmt) {
    // Bind parameters to the SQL query
    $paymentStmt->bind_param(
    "ssssdssssdd",
    $cartID,
    $userID,
    $hotelJson,
    $attJson,
    $totalPrice,
    $fromLocation,
    $destLocation,
    $departDate,
    $returnDate,
    $person,
    $max_budget
    );

    // Execute the query
    if ($paymentStmt->execute()) {
        emptyAllCartData($cartID);
        $_SESSION['success_msg'] = "Payment successful.\n Thank you for purchasing.";
        header("Location: cart.php");
        $paymentStmt->close();
        $conn->close();
        exit();
    } else {
        $_SESSION['error_msg'] = "Error executing payment: " . $paymentStmt->error;
        header("Location: cart.php");
        $paymentStmt->close();
        $conn->close();
        exit;
    }
    

    // Close the statement
} else {
    $_SESSION['error_msg'] = "Error preparing payment statement: " . $conn->error;
    header("Location: cart.php");
    $paymentStmt->close();
    $conn->close();  
    exit; 
}

   

}

function emptyAllCartData($cartID) {
    global $conn;

    // Delete from the cart table
    $delCartSQL = "DELETE FROM cart WHERE cartID = ?";
    $delCartStmt = $conn->prepare($delCartSQL);
    if ($delCartStmt) {
        $delCartStmt->bind_param("s", $cartID);
        $delCartStmt->execute();
        $delCartStmt->close();
    } else {
        error_log("Error preparing statement for cart table: " . $conn->error);
    }

    // Delete from the cart_hotel table
    $delCartHotelSQL = "DELETE FROM cart_hotel WHERE cartID = ?";
    $delCartHotelStmt = $conn->prepare($delCartHotelSQL);
    if ($delCartHotelStmt) {
        $delCartHotelStmt->bind_param("s", $cartID);
        $delCartHotelStmt->execute();
        $delCartHotelStmt->close();
    } else {
        error_log("Error preparing statement for cart_hotel table: " . $conn->error);
    }

    // Delete from the cart_attractions table
    $delCartAttractionsSQL = "DELETE FROM cart_attractions WHERE cartID = ?";
    $delCartAttractionsStmt = $conn->prepare($delCartAttractionsSQL);
    if ($delCartAttractionsStmt) {
        $delCartAttractionsStmt->bind_param("s", $cartID);
        $delCartAttractionsStmt->execute();
        $delCartAttractionsStmt->close();
    } else {
        error_log("Error preparing statement for cart_attractions table: " . $conn->error);
    }
}


?>
