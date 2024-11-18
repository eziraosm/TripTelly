<?php
session_start();

if (!isset($_SESSION["user_login"])) {
    $_SESSION['user_login'] = true;
}
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Traveltelly Sign In </title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/signup.css">
</head>
<body>
<div class="wrapper">
    <h2>Sign In</h2>
    <form action="fn_signin.php" method="POST">
        <?php
        // Display success message if it exists
        if (isset($_SESSION['successMsg'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                . $_SESSION['successMsg'] .
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            unset($_SESSION['successMsg']); // Clear the message after displaying
        }
        if (isset($_SESSION['errorMsg'])) {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
              . $_SESSION['errorMsg'] .
              '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
          unset($_SESSION['errorMsg']); // Clear the message after displaying
      }
        ?>
        <div class="input-box">
            <input type="text" name="email" placeholder="Enter your email" required>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="input-box button">
            <input type="submit" value="Sign In Now">
        </div>
        <div class="text">
            <h3>Does not have an account? <a href="signup.php">Sign Up Now</a></h3>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
