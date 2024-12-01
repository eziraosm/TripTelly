<?php
include("dbconnect.php"); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user inputs
    $userID = $conn->real_escape_string($_POST["userID"]);
    $placeID = $conn->real_escape_string($_POST["placeID"]);
    $reviewText = $conn->real_escape_string($_POST["review_text"]);
    $rating = (float)$_POST["rate"]; // Cast rating to float for validation

    // Validate inputs (optional but recommended)
    if (empty($userID) || empty($placeID) || empty($reviewText) || $rating <= 0 || $rating > 5) {
        $_SESSION["error_msg"] = "Invalid input. Please check your data.";
        // return to previous page
        header("Location: placeDetail.php?placeID=" . $placeID);
        exit;
    }

    // SQL query to insert the review
    $reviewSQL = "INSERT INTO review (placeID, userID, reviewText, reviewTimestamp, reviewRating) 
                  VALUES (?, ?, ?, NOW(), ?)";

    // Prepare the statement
    $stmt = $conn->prepare($reviewSQL);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sssd", $placeID, $userID, $reviewText, $rating);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION["success_msg"] = "Review added successfully!";
        } else {
            $_SESSION["error_nsg"] = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        $_SESSION["error_msg"] = "Error: Unable to prepare the SQL statement. " . $conn->error;
    }

    // Close the database connection
    $conn->close();

    // Redirect back to the previous page
    header("Location: placeDetail.php?placeID=" . $placeID);
    exit;
}
?>
