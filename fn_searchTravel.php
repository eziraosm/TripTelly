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

    
} else {
    echo "Invalid request method.";
}
?>
