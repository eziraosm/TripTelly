<?php
session_start(); // Start session to access session variables
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Telly Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/signup.css">
  </head>
<body>
  <div class="wrapper">
    <h2>Registration</h2>
    <form action="fn_signup.php" method="POST">
      <div class="input-box">
        <input type="text" name="username" placeholder="Enter your user name" required>
      </div>
      <div class="input-box">
        <input type="text" name="fullname" placeholder="Enter your full name" required>
      </div>
      <div class="input-box">
        <input type="text" name="email" placeholder="Enter your email" required>
      </div>
      <div class="input-box">
        <input type="password" id="passwordChecker" name="password" placeholder="Create password" required>
      </div>
      <div class="input-box" id="input-feedback" style="display: none">
        <div class="feedback mt-15 position-relative" id="feedback"></div>
      </div>
      <div class="input-box">
        <input type="password" name="confirm_password" placeholder="Confirm password" required>
      </div>
      <div class="policy">
        <input type="checkbox" required>
        <h3>I accept all terms & conditions</h3>
      </div>
      <div class="input-box button">
        <input type="submit" id="submit" value="Register Now">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="signin.php">Sign In Now</a></h3>
      </div>

      <!-- Conditionally display the alert if errorMsg session exists -->
      <?php if (isset($_SESSION['errorMsg'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <?php
            echo $_SESSION['errorMsg'];
            unset($_SESSION['errorMsg']); // Clear the message after displaying
          ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="assets/js/passwordChecker.js"></script>
  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("passwordChecker");
    const feedbackContainer = document.getElementById("input-feedback");

    passwordInput.addEventListener("input", function () {
      if (passwordInput.value.length > 0) {
        feedbackContainer.style.display = "block";
      } else {
        feedbackContainer.style.display = "none";
      }
    });

    // Initialize the password strength checker
    checkPasswordStrength('passwordChecker');
  });
</script>

</body>
</html>
