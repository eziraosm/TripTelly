<?php
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

?>