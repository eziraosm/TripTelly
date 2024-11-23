<?php
include "dbconnect.php";
function fetchAdminData($adminID)
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

?>