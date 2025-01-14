<?php
include "dbconnect.php";
session_start();

$disabled = ""; // Initialize the variable

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists and is not expired (15 minutes expiration)
    $stmt = $conn->prepare("SELECT * FROM password_reset WHERE token = ? AND created_at > (NOW() - INTERVAL 15 MINUTE)");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows < 0) {
        $_SESSION['errorMsg'] = "Token is invalid or expired.";
        header("Location: resetPassword.php");
    }
}else {
    $_SESSION['errorMsg'] = "Token not found.";
    $disabled = "disabled";
}
?>
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Traveltelly Sign In </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/signup.css">
</head>

<body>
    <div class="wrapper">
        <form action="fn_newPassword.php" method="POST">
            <div class="top-container">
                <h2>Create New Password</h2>
            </div>
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
                <input type="password" name="password" placeholder="Enter your password" required <?= $disabled ?>>
                <input type="hidden" name="token" value="<?= $token ?>">
            </div>
            <div class="input-box h-25" id="show-pwd">
                <i class="bi bi-eye-fill"></i><span id="pwd-text" style="cursor: pointer; user-select: none;">Show
                    Password</span>
            </div>
            <div class="input-box button">
                <input type="submit" value="Reset Password">
            </div>
        </form>
    </div>

    <script>
        // show password
        const showPwd = document.getElementById("show-pwd");
        const pwdText = document.getElementById("pwd-text");
        const pwdInput = document.querySelector("input[name='password']");
        const eyeIcon = document.querySelector(".bi-eye-fill");
        showPwd.addEventListener("click", function () {
            if (pwdInput.type === "password") {
                pwdInput.type = "text";
                pwdText.textContent = "  Hide Password";
                eyeIcon.classList.remove("bi-eye-fill");
                eyeIcon.classList.add("bi-eye-slash-fill");
            } else {
                pwdInput.type = "password";
                pwdText.textContent = "  Show Password";
                eyeIcon.classList.remove("bi-eye-slash-fill");
                eyeIcon.classList.add("bi-eye-fill");
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>