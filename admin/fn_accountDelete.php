<?php
    include 'dbconnect.php';
    session_start();  // Start the session to use $_SESSION

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['deleteAdminID'])) {
            $delID = $_GET['deleteAdminID'];
            $tableName = "admin";
            $fieldName = "adminID";
            $locationReturn = "Location: adminList.php";
        } elseif (isset($_GET['deleteCustomerID'])) {
            $delID = $_GET['deleteCustomerID'];
            $tableName = "user";
            $fieldName = "userID";
            $locationReturn = "Location: customerList.php";
        }

        // Prepare the DELETE SQL query
        $delAccSQL = "DELETE FROM " . $tableName . " WHERE " . $fieldName ." = ?";
        
        // Prepare the statement
        if ($stmt = mysqli_prepare($conn, $delAccSQL)) {
            // Bind the parameter
            mysqli_stmt_bind_param($stmt, "i", $delID); // "i" means integer type
            
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success_msg'] = ucfirst($tableName) . " deleted successfully.";
                header($locationReturn);
            } else {
                // Log and display detailed error information
                $_SESSION['error_msg'] = "Error deleting: " . $tableName . mysqli_stmt_error($stmt) . " | MySQL Error: " . mysqli_error($conn);
                header($locationReturn);
            }
            
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error_msg'] = "Error preparing the SQL query: " . mysqli_error($conn);
            header($locationReturn);
            exit;
        }
    }
?>
