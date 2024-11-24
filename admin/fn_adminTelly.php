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

?>