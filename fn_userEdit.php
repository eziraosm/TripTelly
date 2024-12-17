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

    if (!empty($fullName)) {
        $updateFields[] = 'userFname = ?';
        $queryParams[] = $fullName;
    }
    if (!empty($username)) {
        $updateFields[] = 'username = ?';
        $queryParams[] = $username;
    }
    if (!empty($email)) {
        $updateFields[] = 'userEmail = ?';
        $queryParams[] = $email;
    }
    if (!empty($password)) {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateFields[] = 'userPassword = ?';
        $queryParams[] = $hashedPassword;
    }

    if (!empty($updateFields)) {
        // Add userID to the query parameters
        $queryParams[] = $userID;

        // Prepare the SQL query
        $sql = "UPDATE user SET " . implode(', ', $updateFields) . " WHERE userID = ?";

        // Prepare and execute the statement
        $stmt = $conn->prepare($sql);

        if ($stmt->execute($queryParams)) {
            $_SESSION["success_msg"] = "Data updated successfully.";
            header("Location: userEdit.php");
        } else {
            $_SESSION["error_msg"] = "Data update failed.";
            header("Location: userEdit.php");
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