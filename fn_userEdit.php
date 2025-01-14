<?php
// Include your database connection
require_once 'dbconnect.php';

// Start the session to get the user ID (if required)
session_start();

// Assuming userID is stored in session
$userID = $_SESSION['userID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $fullName = isset($_POST['userFname']) ? trim($_POST['userFname']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['userEmail']) ? trim($_POST['userEmail']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Prepare update query dynamically based on non-empty inputs
    $updateFields = [];
    $queryParams = [];
    $paramTypes = '';

    if (!empty($fullName)) {
        $updateFields[] = 'userFname = ?';
        $queryParams[] = $fullName;
        $paramTypes .= 's'; // Add a type for this parameter
    }
    if (!empty($username)) {
        $updateFields[] = 'username = ?';
        $queryParams[] = $username;
        $paramTypes .= 's'; // Add a type for this parameter
    }
    if (!empty($email)) {
        $updateFields[] = 'userEmail = ?';
        $queryParams[] = $email;
        $paramTypes .= 's'; // Add a type for this parameter
    }
    if (!empty($password)) {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateFields[] = 'userPassword = ?';
        $queryParams[] = $hashedPassword;
        $paramTypes .= 's'; // Add a type for this parameter
    }

    if (!empty($updateFields)) {
        // Add userID to the query parameters
        $queryParams[] = $userID;
        $paramTypes .= 's'; // Add a type for the userID parameter

        // Prepare the SQL query
        $sql = "UPDATE user SET " . implode(', ', $updateFields) . " WHERE userID = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the parameters
            $stmt->bind_param($paramTypes, ...$queryParams);

            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION["success_msg"] = "Data updated successfully.";
                header("Location: userEdit.php");
                exit;
            } else {
                $_SESSION["error_msg"] = "Data update failed: " . $stmt->error;
                header("Location: userEdit.php");
                exit;
            }
        } else {
            // Error preparing the statement
            $_SESSION["error_msg"] = "Failed to prepare the statement: " . $conn->error;
            header("Location: userEdit.php");
            exit;
        }
    } else {
        echo "<script>alert('No changes were made.'); window.location.href='userEdit.php';</script>";
    }
} else {
    // Redirect if the request method is not POST
    header('Location: userUpdate.php');
    exit;
}
?>
