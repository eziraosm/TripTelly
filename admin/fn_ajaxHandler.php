<?php
// Include necessary files
include 'fn_adminTelly.php';
include 'dbconnect.php';

// Handle AJAX request for different actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'getTotalVisitors':
            $result = countTotalVisitor();
            if ($result === false) {
                echo 'Error fetching visitor count';
            } else {
                echo $result;
            }
            break;
        
        case 'getTotalSales':
            $result = countTotalSaleOfWeek();
            if ($result === false) {
                echo 'Error fetching sales data';
            } else {
                echo $result;
            }
            break;
        
        case 'getMostPopularLocation':
            $result = fetchMostPopularLocation();
            if ($result === false) {
                echo 'Error fetching location data';
            } else {
                echo $result;
            }
            break;
        
        case 'getTotalBookings':
            $result = countTotalBooked();
            if ($result === false) {
                echo 'Error fetching booking data';
            } else {
                echo $result;
            }
            break;
        
        default:
            echo 'Invalid action';
            break;
    }
    exit; // End script after the response
} else {
    echo 'No action specified';
}
?>
