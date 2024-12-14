<?php
include 'dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $reviewURL = $_GET['deleteURL'];
    $insertDltSQL = "INSERT INTO review_delete (reviewURL, deleteTimestamp)
                        VALUES (?, NOW())";

    $stmt = $conn->prepare($insertDltSQL);

    if ($stmt) {
        $stmt->bind_param("s", $reviewURL);

        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Review deleted successfully";
        } else {
            $_SESSION["error_msg"] = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION["error_msg"] = "Error: Unable to prepare the SQL statement. " . $conn->error;
    }

    // Close the database connection
    $conn->close();
    // Redirect back to the previous page
    echo '<script type="text/javascript">window.history.go(-2);</script>';
    exit;
}

?>