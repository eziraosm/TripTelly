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

function generateRandomPrice($maxHotelPrice)
{
    $hotel_budget = $maxHotelPrice * 0.25;
    return rand(100, $hotel_budget);
}
?>