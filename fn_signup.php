<?php
session_start(); // Start session to store error messages
include 'dbconnect.php'; // Include the database connection file
include 'fn_triptelly.php'; // Include the functions file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form data
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['errorMsg'] = "Passwords do not match.";
        header("Location: signup.php");
        exit();
    }

    // Check if email already exists
    $checkEmail = "SELECT * FROM user WHERE userEmail = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if (!isset($_SESSION['fromAdmin'])) {
            $_SESSION['errorMsg'] = "Email already registered.";
            header("Location: signup.php");
        } else {
            $_SESSION['error_msg'] = "Email already registered.";
            header("Location: admin/customerRegister.php");
        }
        exit();
    } 

    // Generate a unique user ID
    $userID = generateUserID();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $insertUser = "INSERT INTO user (userID, username, userFname, userEmail, userPassword) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertUser);
    $stmt->bind_param("sssss", $userID, $username, $fullname, $email, $hashedPassword);

    if ($stmt->execute()) {
        if (!isset($_SESSION['fromAdmin'])) {
            $_SESSION['successMsg'] = "Registration successful! Please log in.";
            header("Location: signin.php"); // Redirect to the sign-in page
        } else {
            $_SESSION['success_msg'] = "Registration successful! Please log in.";
            header("Location: admin/customerList.php");
        }
    } else {
        if (!isset($_SESSION['fromAdmin'])) {
            $_SESSION['errorMsg'] = "Registration failed. Please try again.";
            header("Location: signup.php");
        } else {
            $_SESSION['error_msg'] = "Registration failed. Please try again.";
            header("Location: admin/customerRegister.php");
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    exit();
}
?>
