<?php
session_start();
include 'dbconnect.php';
include 'fn_adminTelly.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_POST['userID'];

    // Collect form data
    $userName = isset($_POST['username']) ? trim($_POST['username']) : '';
    $userFName = isset($_POST['userFName']) ? trim($_POST['userFName']) : '';
    $userEmail = isset($_POST['userEmail']) ? trim($_POST['userEmail']) : '';
    $userPassword = isset($_POST['userPassword']) ? trim($_POST['userPassword']) : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';

    // Initialize an array to hold the update statements
    $updateFields = [];
    $updateValues = [];

    // Check if the user is not empty and update if provided
    if ($userName !== '') {
        $updateFields[] = 'username = ?';
        $updateValues[] = $userName;
    }

    // Check if the userFName is not empty and update if provided
    if ($userFName !== '') {
        $updateFields[] = 'userFname = ?';
        $updateValues[] = $userFName;
    }

    // Check if the adminEmail is not empty and update if provided
    if ($userEmail !== '') {
        $updateFields[] = 'userEmail = ?';
        $updateValues[] = $userEmail;
    }

    // Check if the password fields are provided and match
    if ($userPassword !== '' && $userPassword === $confirmPassword) {
        $updateFields[] = 'userPassword = ?';
        $updateValues[] = password_hash($userPassword, PASSWORD_BCRYPT); // Securely hash the password
    } elseif ($userPassword !== '' && $userPassword !== $confirmPassword) {
        // Handle password mismatch (optional: display a message)
        $_SESSION['error_msg'] = "Passwords do not match.";
        header('Location: customerEdit.php?editCustomerID=' . $userID); // Redirect back with error message
        exit;
    }

    // Proceed if there are fields to update
    if (count($updateFields) > 0) {
        // Add the WHERE clause to update the specific admin
        $sql = "UPDATE user SET " . implode(", ", $updateFields) . " WHERE userID = ?";
        $updateValues[] = $userID;

        // Prepare and execute the update query
        if ($stmt = $conn->prepare($sql)) {
            // Bind the values to the statement
            $stmt->bind_param(str_repeat("s", count($updateValues)), ...$updateValues);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['success_msg'] = $userName . " account updated successfully.";
            } else {
                $_SESSION['error_msg'] = "No changes were made.";
            }

            $stmt->close();
        } else {
            $_SESSION['error_msg'] = "Error preparing the query.";
        }
    } else {
        $_SESSION['error_msg'] = "No fields were updated.";
    }

    // Redirect back to the edit page or another page after processing
    header('Location: customerEdit.php?editCustomerID=' . $userID);
    exit;
}

?>