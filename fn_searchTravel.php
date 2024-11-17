<?php
session_start();
include 'fn_triptelly.php';

if (!isset($_SESSION['userID'])) {
    $_SESSION['errorMsg'] = "Login to search for travel";
    $_SESSION['form_data'] = $_POST;
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_SESSION['form_data'])) {
    $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : $_POST;

    // Validate input fields
    $from_loc = $form_data['from_loc'] ?? null;
    $destination_loc = $form_data['destination_loc'] ?? null;
    $departure_date = $form_data['departure_date'] ?? null;
    $return_date = $form_data['return_date'] ?? null;
    $people_num = $form_data['people_num'] ?? null;
    $max_budget = $form_data['max_budget'] ?? null;
    $_SESSION['form_data'] = $_POST;
    // Check for missing fields
    if (empty($from_loc) || empty($destination_loc) || empty($departure_date) || empty($people_num) || empty($max_budget)) {
        $_SESSION['errorMsg'] = "Please fill in all the required fields.";
        header("Location: index.php");
        exit();
    }

    // Google Places API key
    $apiKey = 'AIzaSyBpHdMS0pMIrrjewOeEpo5z-ykG0FMYbiQ';

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
        $radius = 50000; // Search within a 5 km radius
        $type = 'lodging'; // Filter for lodging type

        $placesUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$latitude,$longitude&radius=$radius&type=$type&key=$apiKey";

        // Make the API request for nearby places
        $placesResponse = file_get_contents($placesUrl);

        if ($placesResponse === FALSE) {
            die("Error occurred while fetching data from Google Places API");
        }

        $placesData = json_decode($placesResponse, true);

        if (!empty($placesData['results'])) {
            // Initialize an array to store hotel details
            $hotels = [];

            foreach ($placesData['results'] as $place) {
                $hotels[] = [
                    'name' => $place['name'],
                    'place_id' => $place['place_id'],
                    'address' => $place['vicinity'] ?? 'test',
                    'rating' => $place['rating'] ?? 'N/A',
                    'price' => generateRandomPrice($max_budget),
                    'user_ratings_total' => $place['user_ratings_total'] ?? 0,
                ];
            }

            // Shuffle the hotels array to randomize the order
            shuffle($hotels);

            // Store the hotel data in the session
            $_SESSION['hotel_data'] = $hotels;
            $_SESSION['form_data'] = $_POST;

            $attractionTypes = 'museum|tourist_attraction|point_of_interest'; // POI types for attractions

            $attractionPlacesUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$latitude,$longitude&radius=$radius&type=$attractionTypes&key=$apiKey";
            $attractionPlacesResponse = file_get_contents($attractionPlacesUrl);

            if ($attractionPlacesResponse === FALSE) {
                die("Error occurred while fetching data from Google Places API");
            }

            $attractionPlacesData = json_decode($attractionPlacesResponse, true);

            if (!empty($attractionPlacesData['results'])) {
                $attractions = [];
                foreach ($attractionPlacesData['results'] as $place) {
                    $attractions[] = [
                        'name' => $place['name'],
                        'place_id' => $place['place_id'],
                        'address' => $place['vicinity'] ?? 'N/A',
                        'rating' => $place['rating'] ?? 'N/A',
                        'user_ratings_total' => $place['user_ratings_total'] ?? 0,
                    ];
                }

                shuffle($attractions); // Randomize attractions order
                $_SESSION['attraction_data'] = $attractions;
            } else {
                $_SESSION['errorMsg'] = "No tourist attractions found near the specified location.";
                header("Location: searchForm.php");
                exit();
            }

            // Redirect to searchResult.php
            header("Location: searchHotel.php");
            exit();
        } else {
            $_SESSION['errorMsg'] = "No hotels found near the specified location.";
            header("Location: searchForm.php");
            exit();
        }
    }
}
?>