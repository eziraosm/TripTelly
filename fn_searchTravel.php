<?php
session_start();

if (!isset($_SESSION['userID'])) {
    $_SESSION['errorMsg'] = "Login to search for travel";
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from_loc = $_POST['from_loc'];
    $destination_loc = $_POST['destination_loc'];
    $departure_date = $_POST['departure_date'];
    $return_date = $_POST['return_date'];
    $people_num = $_POST['people_num'];
    $min_budget = $_POST['min_budget'];
    $max_budget = $_POST['max_budget'];

    // Google Places API key
    $apiKey = 'AIzaSyBPPRCXXI6VEcmYilJ9NLelumfUuEfI6qs';

    // Define the location and other search parameters
    $location = '3.1390,101.6869'; // Coordinates for Kuala Lumpur, Malaysia
    $radius = 5000; // Search within 5 km radius
    $type = 'lodging'; // Type filter for hotels/lodging

    // Build the URL for the API request
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$location&radius=$radius&type=$type&key=$apiKey";

    // Make the API request
    $response = file_get_contents($url);

    // Check if the response was successful
    if ($response === FALSE) {
        die("Error occurred while fetching data from Google Places API");
    }

    // Decode JSON response into an array
    $data = json_decode($response, true);

    // Store the results in session
    $_SESSION['hotel_data'] = $data['results']; // Store only the results array

    // Redirect to searchResult.php
    header("Location: searchResult.php");
    exit();
}
?>
