<?php
session_start();
include "dbconnect.php";
include "../fn_triptelly.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminID = generateUserID();
    $adminName = trim($_POST['adminName']);
    $adminFName = trim($_POST['adminFName']);
    $adminEmail = trim($_POST['adminEmail']);
    $adminPassword = trim($_POST['adminPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Check if passwords match
    if ($adminPassword !== $confirmPassword) {
        $_SESSION['error_msg'] = "Passwords do not match.";
        header("Location: adminRegister.php");
        exit();
    }

    // Check if email already exists
    $checkEmail = "SELECT * FROM admin WHERE adminEmail = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $adminEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_msg'] = "Email is already registered.";
        header("Location: adminRegister.php");
        exit();
    } 

    $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

    // Insert user data into the database
    $insertUser = "INSERT INTO admin (adminID, adminName, adminFname, adminEmail, adminPassword) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertUser);
    $stmt->bind_param("sssss", $adminID, $adminName, $adminFName, $adminEmail, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "Registration successful!";
        header("Location: adminList.php"); // Redirect to the sign-in page
    } else {
        $_SESSION['error_msg'] = "Registration failed. Please try again.";
        header("Location: adminRegister.php");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    exit();
}
?>