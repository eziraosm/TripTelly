<?php
    include 'dbconnect.php';
    session_start();  // Start the session to use $_SESSION

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $delAdminID = $_GET['deleteAdminID'];

        // Prepare the DELETE SQL query
        $deleteAdminSQL = "DELETE FROM admin WHERE adminID = ?";
        
        // Prepare the statement
        if ($stmt = mysqli_prepare($conn, $deleteAdminSQL)) {
            // Bind the parameter
            mysqli_stmt_bind_param($stmt, "i", $delAdminID); // "i" means integer type
            
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success_msg'] = "Admin deleted successfully.";
                header("Location: adminList.php");
            } else {
                // Log and display detailed error information
                $_SESSION['error_msg'] = "Error deleting admin: " . mysqli_stmt_error($stmt) . " | MySQL Error: " . mysqli_error($conn);
                header("Location: adminList.php");
            }
            
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['error_msg'] = "Error preparing the SQL query: " . mysqli_error($conn);
            header("Location: adminList.php");
            exit;
        }
    }
?>
