<?php
session_start();
include 'dbconnect.php';
include 'fn_adminTelly.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminID = $_POST['adminID'];

    // Collect form data
    $adminName = isset($_POST['adminName']) ? trim($_POST['adminName']) : '';
    $adminFName = isset($_POST['adminFName']) ? trim($_POST['adminFName']) : '';
    $adminEmail = isset($_POST['adminEmail']) ? trim($_POST['adminEmail']) : '';
    $adminPassword = isset($_POST['adminPassword']) ? trim($_POST['adminPassword']) : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';

    // Initialize an array to hold the update statements
    $updateFields = [];
    $updateValues = [];

    // Check if the adminName is not empty and update if provided
    if ($adminName !== '') {
        $updateFields[] = 'adminName = ?';
        $updateValues[] = $adminName;
    }

    // Check if the adminFName is not empty and update if provided
    if ($adminFName !== '') {
        $updateFields[] = 'adminFname = ?';
        $updateValues[] = $adminFName;
    }

    // Check if the adminEmail is not empty and update if provided
    if ($adminEmail !== '') {
        $updateFields[] = 'adminEmail = ?';
        $updateValues[] = $adminEmail;
    }

    // Check if the password fields are provided and match
    if ($adminPassword !== '' && $adminPassword === $confirmPassword) {
        $updateFields[] = 'adminPassword = ?';
        $updateValues[] = password_hash($adminPassword, PASSWORD_BCRYPT); // Securely hash the password
    } elseif ($adminPassword !== '' && $adminPassword !== $confirmPassword) {
        // Handle password mismatch (optional: display a message)
        $_SESSION['error_msg'] = "Passwords do not match.";
        header('Location: adminEdit.php?editAdminID=' . $adminID); // Redirect back with error message
        exit;
    }

    // Proceed if there are fields to update
    if (count($updateFields) > 0) {
        // Add the WHERE clause to update the specific admin
        $sql = "UPDATE admin SET " . implode(", ", $updateFields) . " WHERE adminID = ?";
        $updateValues[] = $adminID;

        // Prepare and execute the update query
        if ($stmt = $conn->prepare($sql)) {
            // Bind the values to the statement
            $stmt->bind_param(str_repeat("s", count($updateValues)), ...$updateValues);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['success_msg'] = $adminName . " account updated successfully.";
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
    header('Location: adminEdit.php?editAdminID=' . $adminID);
    exit;
}

?>