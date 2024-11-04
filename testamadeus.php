<?php

// API Credentials
$apiKey = 'AIzaSyA5KTxIB18lio6V10J6Qna-qVvkE89e0Nc';
$searchApiKey = 'AIzaSyBPPRCXXI6VEcmYilJ9NLelumfUuEfI6qs'; // Custom Search API key
$searchEngineId = '25a0aa2201a64456e'; // Custom Search Engine ID
$location = '3.139,101.6869'; // Latitude and Longitude for Kuala Lumpur
$radius = 5000; // Search within 5000 meters

// Function to get attractions from Google Places API
function getAttractions($apiKey, $location, $radius) {
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location={$location}&radius={$radius}&type=tourist_attraction&key={$apiKey}";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Function to fetch ticket prices using Google Custom Search API
function getTicketPrice($searchApiKey, $searchEngineId, $attractionName) {
    $query = urlencode($attractionName . " ticket price");
    $url = "https://www.googleapis.com/customsearch/v1?q={$query}&key={$searchApiKey}&cx={$searchEngineId}";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if (isset($data['items']) && count($data['items']) > 0) {
        // Extracting the price information from the first search result
        $snippet = $data['items'][0]['snippet'];
        return extractPrice($snippet);
    } else {
        return "Price not available";
    }
}

// Function to extract price from the text
function extractPrice($text) {
    // Use regular expression to find "RM" followed by numbers
    preg_match('/RM\s*(\d+)/', $text, $matches);
    return isset($matches[1]) ? "RM " . $matches[1] : "Price not available";
}

// Main logic
$attractions = getAttractions($apiKey, $location, $radius);

if (isset($attractions['results'])) {
    foreach ($attractions['results'] as $attraction) {
        $name = $attraction['name'];
        $reviews = isset($attraction['rating']) ? $attraction['rating'] : 'No reviews';
        $ticketPrice = getTicketPrice($searchApiKey, $searchEngineId, $name); // Fetch ticket price
        
        // Output formatted information
        echo "-------------------------------------\n";
        echo "Attraction: $name\n";
        echo "Rating: $reviews\n";
        echo "Ticket Price: $ticketPrice\n";
    }
} else {
    echo "No attractions found.";
}
?>
