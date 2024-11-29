<?php
// Include necessary files
include 'fn_adminTelly.php';
include 'dbconnect.php';

// Handle AJAX request for different actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getTotalVisitors':
            echo countTotalVisitor(); // Fetch total visitors
            break;
        
        case 'getTotalSales':
            echo countTotalSaleOfWeek(); // Fetch total sales in the last week
            break;
        
        case 'getMostPopularLocation':
            echo fetchMostPopularLocation(); // Fetch the most popular location
            break;
        
        case 'getTotalBookings':
            echo countTotalBooked(); // Fetch total bookings
            break;
        
        default:
            echo 'Invalid action';
            break;
    }
    exit; // End script after the response
}
?>
