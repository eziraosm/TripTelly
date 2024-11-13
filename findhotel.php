<?php
// Google Places API key
$apiKey = 'AIzaSyBPPRCXXI6VEcmYilJ9NLelumfUuEfI6qs';

// Define the location and other search parameters
$location = '3.13,101.68'; // Coordinates for Kuala Lumpur, Malaysia
$radius = 100000; // Search within 5 km radius
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

// Display the JSON response (Formatted output)
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>
