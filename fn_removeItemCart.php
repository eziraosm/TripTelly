<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Get userID and the type of item to be removed
$userID = $_SESSION['userID'];
$itemType = isset($_GET['type']) ? $_GET['type'] : '';
$itemID = isset($_GET['id']) ? $_GET['id'] : '';
$cartID = isset($_GET['cartID']) ? $_GET['cartID'] : '';

if (empty($itemType) || empty($itemID)) {
    header("Location: cart.php");
    exit();
}

// SQL query based on item type (either 'hotel' or 'attraction')
if ($itemType === 'hotel') {
    $sql = "DELETE FROM cart_hotel WHERE hotelID = ? AND cartID = ?";
} elseif ($itemType === 'attraction') {
    $sql = "DELETE FROM cart_attractions WHERE attID = ? AND cartID = ?";
} else {
    // Invalid item type
    header("Location: cart.php");
    exit();
}

// Prepare and bind the SQL query
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $itemID, $cartID);

// Execute the query
if ($stmt->execute()) {
    $_SESSION["success_msg"] = ucfirst($itemType) . " item removed successfully.";
    header("Location: cart.php");
} else {
    $_SESSION["error_msg"] = $itemType . " item removed failed: " . $stmt->error;
    header("Location: cart.php");
}
?>