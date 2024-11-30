<?php
include "dbconnect.php";

function generateUserID($length = 8)
{
    return bin2hex(random_bytes($length)); // Generates a random string of the specified length
}

function generateCartID()
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-';
    $id = '';
    for ($i = 0; $i < 11; $i++) {
        $id .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $id;
}

function generateHotelPrice($maxHotelPrice)
{
    $hotel_budget = $maxHotelPrice * 0.25;
    return rand(100, $hotel_budget);
}

function generateAttractionPrice($maxAttractionBudget)
{
    $attraction_budget = $maxAttractionBudget * 0.6;
    // 5% chance to exceed 100
    if (rand(1, 100) <= 10) {
        // Ensure the price is more than 100 but within the maximum budget
        return rand(101, $attraction_budget);
    }

    // Otherwise, return a regular price between 3 and 100
    return rand(3, min(100, $attraction_budget));
}

function getTotalCartPrice()
{
    // Ensure userID is set in the session
    if (!isset($_SESSION['userID'])) {
        return 0; // Return 0 if no user ID is found
    }

    $userID = $_SESSION['userID'];
    $totalPrice = 0;

    // Ensure $conn is included from dbconnect.php (which uses mysqli)
    global $conn;

    // SQL query to calculate the total price for hotels and attractions for the current user
    $sql = "
    SELECT 
        (SELECT SUM(h.hotelPrice) 
         FROM cart_hotel h 
         WHERE h.cartID IN (SELECT cartID FROM cart WHERE userID = '$userID')) AS totalHotelPrice,
        (SELECT SUM(a.attPrice) 
         FROM cart_attractions a 
         WHERE a.cartID IN (SELECT cartID FROM cart WHERE userID = '$userID')) AS totalAttractionPrice
";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Fetch the result
        $row = mysqli_fetch_assoc($result);

        // Calculate the total price
        $totalPrice = ($row['totalHotelPrice'] ?? 0) + ($row['totalAttractionPrice'] ?? 0);
    } else {
        // Error handling for query execution
        echo "Error: " . mysqli_error($conn);
    }

    return $totalPrice;
}

function fetchPlaceDetail($placeID)
{
    // Your Google API Key
    $apiKey = 'AIzaSyBpHdMS0pMIrrjewOeEpo5z-ykG0FMYbiQ';

    // Google Places Details API endpoint
    $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id=" . urlencode($placeID) . "&key=" . $apiKey;

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    // Close the cURL session
    curl_close($ch);

    // Decode the JSON response
    $placeDetails = json_decode($response, true);

    // Check if the request was successful
    if (isset($placeDetails['status']) && $placeDetails['status'] === 'OK') {
        return $placeDetails['result'];
    } else {
        // Log error for debugging
        if (isset($placeDetails['status'])) {
            echo 'Error: ' . $placeDetails['status'];
        }
        return null;
    }
}
?>