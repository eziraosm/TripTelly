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

$tripData = fetchTripData($userID);
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>

    <!--style.css-->
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Purchase History</title>
    <link rel="stylesheet" href="assets/css/searchResult.css">
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <!-- ajax -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- datatable -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <style>
        main {
            min-height: 92vh;
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
                        <div class="card-header d-flex justify-content-between">
                            <div class="table-title">
                                <i class="fas fa-table me-1"></i>
                                Purchase History
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>From Location</th>
                                        <th>Destination Location</th>
                                        <th>Departure Date</th>
                                        <th>Return Date</th>
                                        <th>Person</th>
                                        <th>Budget</th>
                                        <th>Payment Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>From Location</th>
                                        <th>Destination Location</th>
                                        <th>Departure Date</th>
                                        <th>Return Date</th>
                                        <th>Person</th>
                                        <th>Budget</th>
                                        <th>Payment Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // var_dump($tripData);
                                    foreach ($tripData as $trip) {
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars(strtoupper($trip['fromLocation'])) ?></td>
                                            <td><?= htmlspecialchars(strtoupper($trip['destinationLocation'])) ?></td>
                                            <td><?= htmlspecialchars($trip['departureDate']) ?></td>
                                            <td><?= htmlspecialchars($trip['returnDate']) ?></td>
                                            <td><?= htmlspecialchars($trip['person']) ?></td>
                                            <td>RM <?= htmlspecialchars($trip['max_budget']) ?></td>
                                            <td><?= htmlspecialchars($trip['paymentDate']) ?></td>
                                            <td><a href="purchaseHistory.php?paymentID=<?= htmlspecialchars(strtoupper($trip['paymentID'])) ?>"
                                                    class="btn btn-success">Detail</a></td>
                                        </tr>
                                        <?php
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php
                    if (isset($_GET['paymentID'])) {
                        $paymentID = $_GET['paymentID'];
                        $placeHotelData = fetchTripDataArrayPlace($paymentID);
                        $trip = fetchTripDataWithPaymentID($paymentID);
                        // var_dump($trip);
                        // echo $placeHotelData['hotelName'];
                        ?>
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <div class="table-title">
                                    <i class="fas fa-table me-1"></i>
                                    <?= strtoupper($trip['fromLocation']) . " <i class='bx bx-right-arrow-alt' ></i> " . strtoupper($trip['destinationLocation']) ?>
                                </div>
                                <div class="register-btn">
                                    <button class="btn btn-danger" style="font-size: 20px" onclick="removeGetData()"><i class='bx bx-x'></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Place Name</th>
                                            <th>Place Price</th>
                                            <th>Place Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Place Name</th>
                                            <th>Place Price</th>
                                            <th>Place Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        // Ensure we have data before rendering
                                        if (!empty($placeHotelData)) {
                                            // Render hotel details first
                                            if (!empty($placeHotelData['hotelName'])) {
                                                ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($placeHotelData['hotelName'] ?? 'N/A') ?></td>
                                                    <td>RM <?= htmlspecialchars($placeHotelData['hotelPrice'] ?? 'N/A') ?></td>
                                                    <td><?= htmlspecialchars($placeHotelData['hotelLocation'] ?? 'N/A') ?></td>
                                                    <td><a href="placeDetailReview.php?placeID=<?= $placeHotelData['hotelID'] ?>"
                                                            class="btn btn-success">Review</a></td>
                                                </tr>
                                                <?php
                                            }
                                            // Render attractions
                                            foreach ($placeHotelData as $place) {
                                                if (!empty($place['attName']) || !empty($place['attPrice']) || !empty($place['attLocation'])) {
                                                    ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($place['attName'] ?? 'N/A') ?></td>
                                                        <td>RM <?= htmlspecialchars($place['attPrice'] ?? 'N/A') ?></td>
                                                        <td><?= htmlspecialchars($place['attLocation'] ?? 'N/A') ?></td>
                                                        <td><a href="placeDetailReview.php?placeID=<?= $place['attID'] ?>"
                                                                class="btn btn-success">Review</a></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="3">No data available</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    }
                    ?>



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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="admin/js/datatables-simple-demo.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Select all tables with the "datatablesSimple" class
            const tables = document.querySelectorAll(".datatablesSimple");

            // Loop through the NodeList and initialize DataTables for each
            tables.forEach((table) => {
                new simpleDatatables.DataTable(table);
            });
        });

        function removeGetData() {
            // Create a URL object for the current page
            var currentUrl = new URL(window.location.href);

            // Remove the query parameters (GET data)
            currentUrl.search = ''; // Clears all query parameters

            // Reload the page without the query string
            window.location.href = currentUrl.toString();
        }

    </script>

</body>

</html>