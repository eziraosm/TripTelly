<?php
session_start();
include "dbconnect.php";
include "fn_triptelly.php";

if (isset($_SESSION['userID'])) {

    $userID = $_SESSION['userID'];
    $userDataQuery = "SELECT * FROM user WHERE userID = ?";
    $stmt = $conn->prepare(query: $userDataQuery);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        $username = $userData['username'];
    } else {
        $username = null;
    }
}


// Toast controller
$toastMessage = '';
$toastClass = '';

if (isset($_SESSION['success_msg'])) {
    $toastMessage = $_SESSION['success_msg'];
    $toastClass = 'bg-success';
    unset($_SESSION['success_msg']);
} elseif (isset($_SESSION['error_msg'])) {
    $toastMessage = $_SESSION['error_msg'];
    $toastClass = 'bg-danger';
    unset($_SESSION['error_msg']);
}

$userData = fetchUserData($_SESSION['userID']);
$tripCount = count(fetchTripData(userID: $_SESSION['userID']));
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>

    <!--style.css-->
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Attractions Result</title>
    <link rel="stylesheet" href="assets/css/searchResult.css">
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        main {
            height: 92vh;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="logo">
            <a href="index.php">
                trip<span>Telly</span>
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <ul class="navbar-nav mr-auto" style="margin-left:10px">
                    <li class="nav-item">
                        <a class="nav-link" href="searchHotel.php">Hotels <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="searchAttractions.php">Attractions</a>
                    </li>
                </ul>
            </ul>
            <div class="action-btn">
                <button class="cart-btn position-relative">
                    <a href="cart.php"><i class="bx bxs-cart"></i></a>
                    <?php
                    if (isset($_SESSION['cartID'])) {
                        ?>
                        <span
                            class="position-absolute bottom-60 start-70 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                        <?php
                    }
                    ?>
                </button>
                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"><?php echo htmlspecialchars($username) ?></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item"
                                    href="userEdit.php?editUserID=<?php echo $_SESSION['userID']; ?>">Account
                                    Setting</a></li>
                            <li><a class="dropdown-item" href="purchaseHistory.php">Purchase History</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="fn_signout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <!-- toast container -->
        <?php if (!empty($toastMessage)): ?>
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast <?php echo $toastClass; ?>" role="alert" aria-live="assertive"
                    aria-atomic="true" data-autohide="false">
                    <div class="toast-header">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body" style="color: whitesmoke;">
                        <?php echo htmlspecialchars($toastMessage); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <div class="container">
            <div class="title">
                <h3></h3>
            </div>
            <div class="hotel-table">
                <div class="container my-4">

                    <div class="card mb-4">
                        <form action="fn_userEdit.php" method="post">
                            <div class="card-header d-flex justify-content-between">
                                <div class="table-title">
                                    User Info
                                </div>
                                <div class="register-btn">
                                    <button type="submit" id="submit" class="btn btn-success">
                                        <i class="bx bxs-save" style="font-size: 20px"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table  table-striped table-hover"
                                    style="height: 300px; border-radius: 5px; overflow: hidden;">

                                    <tr>
                                        <th>Full Name</th>
                                        <td><input type="text" name="userFname" value="<?= $userData['userFname'] ?>"
                                                class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th>UserName</th>
                                        <td><input type="text" name="username" value="<?= $userData['username'] ?>"
                                                class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><input type="text" name="userEmail" value="<?= $userData['userEmail'] ?>"
                                                class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td>
                                            <input type="password" name="password" id="passwordChecker" value=""
                                                class="form-control">
                                            <div class="input-box h-25" id="show-pwd">
                                                <i class="bi bi-eye-fill"></i><span id="pwd-text"
                                                    style="cursor: pointer; user-select: none;"> Show Password</span>
                                            </div>

                                            <div class="feedback mt-15 position-absolute" id="feedback"></div>
                                        </td>
                                    </tr>
                                    <tr style="background-color: #fff">
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var toastEl = document.getElementById('liveToast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    </script>
    <script src="assets/js/passwordChecker.js"></script>
    <script>
        checkPasswordStrength('passwordChecker');
    </script>
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

</body>

</html>