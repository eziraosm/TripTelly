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

    // Step 1: Convert destination location to latitude and longitude using Geocoding API
    $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($destination_loc) . "&key=$apiKey";

    // Make the API request for geocoding
    $geocodeResponse = file_get_contents($geocodeUrl);

    if ($geocodeResponse === FALSE) {
        die("Error occurred while fetching data from Google Geocoding API");
    }

    $geocodeData = json_decode($geocodeResponse, true);

    // Check if any results were returned
    if (isset($geocodeData['results'][0])) {
        $latitude = $geocodeData['results'][0]['geometry']['location']['lat'];
        $longitude = $geocodeData['results'][0]['geometry']['location']['lng'];
        
        // Step 2: Use the coordinates to search for hotels
        $radius = 5000; // Search within a 5 km radius
        $type = 'lodging'; // Filter for lodging type

        $placesUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$latitude,$longitude&radius=$radius&type=$type&key=$apiKey";

        // Make the API request for nearby places
        $placesResponse = file_get_contents($placesUrl);

        if ($placesResponse === FALSE) {
            die("Error occurred while fetching data from Google Places API");
        }

        $placesData = json_decode($placesResponse, true);

        // Store the results in the session
        $_SESSION['hotel_data'] = $placesData['results'];
        $_SESSION['max_budget'] = $max_budget;

        // Redirect to searchResult.php
        header("Location: searchResult.php");
        exit();
    } else {
        $_SESSION['errorMsg'] = "Location not found. Please enter a valid destination.";
        header("Location: searchForm.php");
        exit();
    }
}

?>
