<?php
session_start(); // Start the session
include 'dbconnect.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch the form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    // check if the user is an admin. If not ->
    if (!isset($_POST['isAdmin'])) {
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
                if (isset($_SESSION['form_data'])) {
                    $form_data = $_SESSION['form_data'];
                    $_SESSION['max_budget'] = $form_data['max_budget'];
                    $_SESSION['destination'] = $form_data['destination_loc'];
                    // Redirect back to fn_searchTravel.php with the form data
                    header("Location: fn_searchTravel.php");
                    exit();
                } else {
                    // Redirect to a welcome page or user dashboard
                    header("Location: index.php");
                }
            } else {
                $_SESSION['errorMsg'] = "Invalid email or password. Please try again.";
                header("Location: signin.php");
            }
        } else {
            $_SESSION['errorMsg'] = "No account found.";
            header("Location: signin.php");
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        exit();
    } elseif ($_POST['isAdmin'] == 'Yes' || isset($_POST['isAdmin'])) {
        // Check if user exists
        $checkUser = "SELECT * FROM admin WHERE adminEmail = ?";
        $stmt = $conn->prepare($checkUser);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['adminPassword'])) {
                $_SESSION['adminID'] = $user['adminID'];
                header("Location: admin/index.php");
                exit();
            } else {
                $_SESSION['errorMsg'] = "Invalid email or password. Please try again.";
                header("Location: signin.php");
            }
        } else {
            $_SESSION['errorMsg'] = "No account found.";
            header("Location: signin.php");
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        exit();
    }
}
?>