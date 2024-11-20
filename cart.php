<?php
session_start();
include 'dbconnect.php';

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

    // Delete cart if it has no hotels or attractions
    $checkCartQuery = "
        SELECT COUNT(*) AS totalItems 
        FROM (
            SELECT hotelID AS itemID FROM cart_hotel WHERE cartID IN (SELECT cartID FROM cart WHERE userID = ?)
            UNION ALL
            SELECT attID AS itemID FROM cart_attractions WHERE cartID IN (SELECT cartID FROM cart WHERE userID = ?)
        ) AS items";
    $stmt = $conn->prepare($checkCartQuery);
    $stmt->bind_param("ss", $userID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['totalItems'] == 0) {
        $deleteCartQuery = "DELETE FROM cart WHERE userID = ?";
        $stmt = $conn->prepare($deleteCartQuery);
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        unset($_SESSION['cartID']);
    }

    // Fetch username
    $userDataQuery = "SELECT username FROM user WHERE userID = ?";
    $stmt = $conn->prepare($userDataQuery);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $username = $result->num_rows > 0 ? $result->fetch_assoc()['username'] : 'Guest';

    // Fetch cart details (excluding hotels and attractions)
    $cartQuery = "SELECT * FROM cart WHERE userID = ?";
    $stmt = $conn->prepare($cartQuery);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $cartResult = $stmt->get_result();
    $cartData = [];
    while ($row = $cartResult->fetch_assoc()) {
        $cartData[] = $row;
    }

    // Fetch hotel data
    $hotelQuery = "SELECT hotelID, hotelName, hotelLocation, hotelPrice, cartID FROM cart_hotel WHERE cartID IN (SELECT cartID FROM cart WHERE userID = ?)";
    $stmt = $conn->prepare($hotelQuery);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $hotelResult = $stmt->get_result();
    $hotelData = [];
    while ($row = $hotelResult->fetch_assoc()) {
        $hotelData[] = $row;
    }

    // Fetch attraction data
    $attQuery = "SELECT attID, attName, attLocation, attPrice, cartID FROM cart_attractions WHERE cartID IN (SELECT cartID FROM cart WHERE userID = ?)";
    $stmt = $conn->prepare($attQuery);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $attResult = $stmt->get_result();
    $attData = [];
    while ($row = $attResult->fetch_assoc()) {
        $attData[] = $row;
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

$max_budget =  isset($firstRow['max_budget']) ? $firstRow['max_budget'] : "0.00"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--style.css-->
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Cart</title>
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
		integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
		crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/cart.css">
</head>

<body>
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
            <ul class="navbar-nav mr-auto" style="margin-left:10px">
				<li class="nav-item ">
					<a class="nav-link" href="searchHotel.php">Hotels</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="searchAttractions.php">Attractions</a>
				</li>
			</ul>
            <div class="action-btn">
                <button class="cart-btn">
                    <a href="cart.php"><i class="bx bxs-cart"></i></a>
                </button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='fn_signout.php'"><?php echo htmlspecialchars($username) ?></button>
            </div>
        </div>
    </nav>
    
    <main>
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12">
                        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-8">
                                        <div class="p-5">
                                            <h1 class="fw-bold mb-0">Travel Cart</h1>
                                            <div class="travel-data-container mb-5 mt-3">
                                                <?php if (!empty($cartData)) {
                                                    $firstRow = $cartData[0];
                                                    $_SESSION['form_data'] = $cartData[0];
                                                    $cartID = $firstRow['cartID'];
                                                    ?>
                                                    <h5><?php echo $firstRow['fromLocation']; ?> <i
                                                            class='bx bx-right-arrow-alt'></i>
                                                        <?php echo $firstRow['destinationLocation']; ?></h5>
                                                    <h6><?php echo $firstRow['departureDate']; ?> <i
                                                            class='bx bx-right-arrow-alt'></i>
                                                        <?php echo $firstRow['returnDate']; ?></h6>
                                                    <h6><?php echo $firstRow['member']; ?> Person</h6>
                                                    <h6>RM <?php echo $firstRow['max_budget']; ?> budgets</h6>
                                                <?php } ?>
                                            </div>

                                            <!-- Hotels Section -->
                                            <h5>Hotels</h5>
                                            <hr class="my-4">
                                            <?php 
                                            $hotelTotal = 0;
                                            $hasHotelItems = false;
                                            foreach ($hotelData as $row) {
                                                $hotelTotal += $row['hotelPrice'];
                                                $hasHotelItems = true; ?>
                                                <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                    <div class="col-md-5">
                                                        <h7><?php echo htmlspecialchars($row['hotelName']); ?></h7>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <h7>RM<?php echo htmlspecialchars(number_format($row['hotelPrice'], 2)); ?></h7>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="fn_removeItemCart.php?type=hotel&id=<?php echo $row['hotelID']; ?>&cartID=<?php echo $cartID ?>">
                                                            <i class='bx bx-x-circle' style='color:#dd2525'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
                                            <?php }
                                            if (!$hasHotelItems) { ?>
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <a href="searchHotel.php" class="btn btn-primary">Search Hotels</a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <!-- Attractions Section -->
                                            <h5>Attractions</h5>
                                            <hr class="my-4">
                                            <?php 
                                            $attractionTotal = 0;
                                            $hasAttractionItems = false;
                                            foreach ($attData as $row) {
                                                $attractionTotal += $row['attPrice'];
                                                $hasAttractionItems = true; ?>
                                                <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                    <div class="col-md-5">
                                                        <h7><?php echo htmlspecialchars($row['attName']); ?></h7>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <h7>RM<?php echo htmlspecialchars(number_format($row['attPrice'], 2)); ?></h7>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="fn_removeItemCart.php?type=attraction&id=<?php echo $row['attID']; ?>&cartID=<?php echo $cartID ?>">
                                                            <i class='bx bx-x-circle' style='color:#dd2525'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
                                            <?php }
                                            if (!$hasAttractionItems) { ?>
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <a href="searchAttractions.php" class="btn btn-primary">Search Attractions</a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <!-- Summary Section -->
                                    <div class="col-lg-4 bg-body-tertiary summary-container">
                                        <div class="p-5">
                                            <h3 class="fw-bold">Summary</h3>
                                            <hr>
                                            <h6>Maximum Budge:</h6>
                                            <div class="total"><?php echo "RM " . $max_budget ?></div>
                                            <hr>
                                            <h5>Hotels Total: </h5>
                                            <div class="total">
                                                <span>RM<?php echo number_format($hotelTotal, 2); ?></span>
                                            </div>
                                            <h5>Attractions Total: </h5>
                                            <div class="total">
                                                <span>RM<?php echo number_format($attractionTotal, 2); ?></span>
                                            </div>
                                            <h5>Grand Total: </h5>
                                            <div class="total">
                                                <h6>RM<?php echo number_format($hotelTotal + $attractionTotal, 2); ?></h6>
                                            </div>
                                            <button class="btn btn-dark btn-block btn-lg">Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
</body>

</html>
