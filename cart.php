<?php
session_start();
include 'dbconnect.php';

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/cart.css">
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
                <!-- <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li> -->
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
                                            <h1 class="fw-bold mb-0">Shopping Cart</h1>
                                            <div class="travel-data-container mb-5 mt-3">
                                                <?php if (!empty($cartData)) {
                                                    $firstRow = $cartData[0];
                                                    $cartID = $firstRow['cartID'];
                                                    ?>
                                                    <h5><?php echo $firstRow['fromLocation']; ?> <i
                                                            class='bx bx-right-arrow-alt'></i>
                                                        <?php echo $firstRow['destinationLocation']; ?></h5>
                                                    <h6><?php echo $firstRow['departureDate']; ?> <i
                                                            class='bx bx-right-arrow-alt'></i>
                                                        <?php echo $firstRow['returnDate']; ?></h6>
                                                    <h6><?php echo $firstRow['member']; ?> Person</h6>
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
                                                    <a href="fn_removeItemCart.php?type=hotel&id=<?php echo $row['hotelID']; ?>&cartID=<?php echo $cartID ?>">
                                                        <i class='bx bx-x-circle' style='color:#dd2525'></i>
                                                    </a>
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
                                                    <a href="fn_removeItemCart.php?type=attraction&id=<?php echo $row['attID']; ?>&cartID=<?php echo $cartID ?>">
                                                        <i class='bx bx-x-circle' style='color:#dd2525'></i>
                                                    </a>
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
</body>

</html>
