<?php
include "dbconnect.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $token = $_POST['token'];

    // Validate the token again
    $stmt = $conn->prepare("SELECT * FROM password_reset WHERE token = ? AND created_at > (NOW() - INTERVAL 15 MINUTE)");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $resetRequest = $result->fetch_assoc();
        $email = $resetRequest['email'];

        // Reset the password in the users table
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $updateStmt = $conn->prepare("UPDATE user SET userPassword = ? WHERE userEmail = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $email);
        $updateStmt->execute();

        // Optionally, delete the token after use
        $deleteStmt = $conn->prepare("DELETE FROM password_reset WHERE token = ?");
        $deleteStmt->bind_param("s", $token);
        $deleteStmt->execute();

        // Set a session variable to indicate success
        $_SESSION['successMsg'] = 'Password has been reset successfully.';

        // Redirect to the sign-in page
        header('Location: signin.php');
        exit();
    } else {
        $_SESSION['errorMsg'] = 'This link is either invalid or has expired.';
        // Redirect to the sign-in page
        header('Location: signin.php');
    }

    $stmt->close();
}

?>