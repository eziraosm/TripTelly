<?php
include 'dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $reviewID = $_GET['reviewID'];
    $dltSQL = "DELETE FROM review WHERE reviewID = ?";

    // Prepare the statement
    if ($stmt = mysqli_prepare($conn, $dltSQL)) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "i", $reviewID); // "i" means integer type
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_msg'] = "Review deleted successfully.";
        } else {
            // Log and display detailed error information
            $_SESSION['error_msg'] = "Error deleting: " . mysqli_stmt_error($stmt) . " | MySQL Error: " . mysqli_error($conn);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_msg'] = "Error preparing the SQL query: " . mysqli_error($conn);
        exit;
    }

    // Close the database connection
    $conn->close();
    // Redirect back to the previous page
    echo '<script type="text/javascript">window.history.go(-2);</script>';
    exit;
}

?>