<?php
include "dbconnect.php";
function fetchCurrentAdminData($adminID)
{
    global $conn;

    $adminDataQuery = "SELECT * FROM admin WHERE adminID = ?";
    $stmt = $conn->prepare(query: $adminDataQuery);
    $stmt->bind_param("s", $adminID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $adminData = $result->fetch_assoc();
        return $adminData;
    } else {
        return null;
    }
}

function fetchAllAdminData()
{
    global $conn;

    // Query to fetch all admin data
    $adminSQL = "SELECT * FROM admin";

    // Execute the query
    $result = mysqli_query($conn, $adminSQL);

    // Check if the query was successful
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return [];
    }

    // Fetch all rows as an associative array
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Free the result set
    mysqli_free_result($result);

    return $data;
}

function fetchCurrentCustomerData($customerID)
{
    global $conn;

    $customerDataQuery = "SELECT * FROM user WHERE userID = ?";
    $stmt = $conn->prepare(query: $customerDataQuery);
    $stmt->bind_param("s", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customerData = $result->fetch_assoc();
        return $customerData;
    } else {
        return null;
    }
}

function fetchAllCustomerData()
{
    global $conn;

    // Query to fetch all admin data
    $adminSQL = "SELECT * FROM user";

    // Execute the query
    $result = mysqli_query($conn, $adminSQL);

    // Check if the query was successful
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return [];
    }

    // Fetch all rows as an associative array
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Free the result set
    mysqli_free_result($result);

    return $data;
}


function countTotalSaleOfWeek() {
    global $conn;

    // SQL query to calculate the total sales from the past 7 days
    $query = "
        SELECT SUM(totalPrice) AS total_sales
        FROM payment
        WHERE paymentDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    ";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Fetch the result
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_sales'] ? $row['total_sales'] : 0; // Return total sales or 0 if null
    } else {
        // Handle query execution error
        die("Query failed: " . mysqli_error($conn));
    }
}

function fetchMostPopularLocation() {
    global $conn;

    // SQL query to find the most picked destinationLocation
    $query = "
        SELECT destinationLocation, COUNT(destinationLocation) AS location_count
        FROM payment
        GROUP BY destinationLocation
        ORDER BY location_count DESC
        LIMIT 1
    ";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Fetch the result
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return ucwords($row['destinationLocation']);
    } else {
        // Handle no results found
        return "No popular destination found";
    }
}


function countTotalVisitor() {
    global $conn;

    // SQL query to count all rows in the user_engagement table
    $query = "SELECT COUNT(*) AS total_visitors FROM user_engagement";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Fetch the result
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_visitors']; // Return the total count
    } else {
        // Handle query failure
        return 0;
    }
}


function countTotalBooked() {
    global $conn;

    // SQL query to count all rows in the payment table
    $query = "SELECT COUNT(*) AS total_payments FROM payment";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Fetch the result
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_payments']; // Return the total count
    } else {
        // Handle query failure
        return 0;
    }
}

function fetchCartAndBook() {
    global $conn;

    // SQL query to combine cart and payment data
    $query = "
        SELECT 
            CONVERT(userID USING utf8mb4) AS userID, 
            NULL AS totalPrice, 
            CONVERT(fromLocation USING utf8mb4) AS fromLocation, 
            CONVERT(destinationLocation USING utf8mb4) AS destinationLocation, 
            departureDate, 
            returnDate, 
            member AS person, 
            'Incomplete' AS status
        FROM 
            cart
        UNION
        SELECT 
            CONVERT(userID USING utf8mb4) AS userID, 
            totalPrice, 
            CONVERT(fromLocation USING utf8mb4) AS fromLocation, 
            CONVERT(destinationLocation USING utf8mb4) AS destinationLocation, 
            departureDate, 
            returnDate, 
            person, 
            'Completed' AS status
        FROM 
            payment;
    ";

    // Execute the query
    $result = $conn->query($query);

    if (!$result) {
        die("Error fetching data: " . $conn->error);
    }

    // Fetch and return data
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $user = fetchCurrentCustomerData($row['userID']);
        $userName = $user['username'];
        $row['userName'] = $userName;
        $data[] = $row;
    }

    return $data;
}


?>