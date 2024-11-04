<?php
session_start(); // Start the session
include 'dbconnect.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch the form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if user exists
    $checkUser = "SELECT * FROM user WHERE userEmail = ?";
    $stmt = $conn->prepare($checkUser);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['userPassword'])) {
            $_SESSION['userID'] = $user['userID'];
            // Redirect to a welcome page or user dashboard
            header("Location: index.php");
        } else {
            $_SESSION['errorMsg'] = "Invalid password. Please try again.";
            header("Location: signin.php");
        }
    } else {
        $_SESSION['errorMsg'] = "No account found with that email.";
        header("Location: signin.php");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    exit();
}
?>
