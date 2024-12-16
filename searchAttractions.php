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

if (isset($_SESSION['userID'])) {
	$userID = $_SESSION['userID'];

	// Fetch current cartID
	$cartQuery = "SELECT cartID FROM cart WHERE userID = ?";
	$stmt = $conn->prepare($cartQuery);
	$stmt->bind_param("s", $userID);
	$stmt->execute();
	$result = $stmt->get_result();

	$cartID = null;
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$cartID = $row['cartID'];
	}

	// Fetch attractions already in the cart
	$bookedAttractions = [];
	if ($cartID) {
		$bookedQuery = "SELECT attID FROM cart_attractions WHERE cartID = ?";
		$stmt = $conn->prepare($bookedQuery);
		$stmt->bind_param("s", $cartID);
		$stmt->execute();
		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
			$bookedAttractions[] = $row['attID'];
		}
	}
}

// Check if attraction data exists in the session
if (!isset($_SESSION['attraction_data'])) {
	echo "No search results found.";
	exit();
}

$form_data = $_SESSION['form_data'];
$attraction_data = $_SESSION['attraction_data'];

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
$destination = $destination_location = isset($form_data['destination_loc']) ? $form_data['destination_loc'] : $form_data["destinationLocation"];

// change sticky container if over budget
if (getTotalCartPrice() > $form_data['max_budget']) {
	$stickyClass = "over-budget";
} else {
	$stickyClass = "price-display";
}
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
							data-bs-toggle="dropdown" aria-expanded="false"><?php echo htmlspecialchars($username) ?></a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item"
									href="userEdit.php?editUserID=<?php echo $_SESSION['userID']; ?>">Account
									Setting</a></li>
							<li>
								<hr class="dropdown-divider" />
							</li>
							<li><a class="dropdown-item" href="../fn_signout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="sticky-container">
		<div class="<?php echo $stickyClass ?>">
			<div class="current-display">
				Current: <span class="price">RM <?php echo number_format(getTotalCartPrice(), 2) ?></span>
			</div>
			<div class="budget-display">
				Budget: <span class="price"> RM <?php echo number_format($form_data['max_budget'], 2) ?></span>
			</div>
		</div>
	</div>
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
				<h3>Attractions in <?php echo $destination ?></h3>
				<h5>Select places you would like to visit</h5>
			</div>
			<div class="hotel-table">
				<div class="container my-4">
					<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 justify-content-center">
						<?php
						foreach ($attraction_data as $key => $poi) {
							$isBooked = in_array($poi['place_id'], $bookedAttractions);
							$photoURL = isset($poi['photo_url']) ? htmlspecialchars($poi['photo_url']) : "https://png.pngtree.com/png-vector/20190820/ourmid/pngtree-no-image-vector-illustration-isolated-png-image_1694547.jpg";
							?>
							<div class="col">
								<div class="card h-100 d-flex flex-column">
									<img src="<?php echo $photoURL; ?>" class="card-img-top img-fluid object-fit-cover"
										style="height: 200px;" alt="Hotel Image">
									<div class="card-body d-flex flex-column">
										<h6 class="card-title"><?php echo $poi["name"] ?></h6>
										<p class="card-text"><?php echo htmlspecialchars($poi['address']); ?></p>
										<div
											class="price-rating w-100 d-flex justify-content-between align-items-center mt-auto">
											<p>RM <?php echo htmlspecialchars($poi['price']); ?></p>
											<p>
												<?php echo htmlspecialchars($poi['rating']); ?>
												<i class='bx bxs-star'></i>
											</p>
										</div>
										<form action='fn_bookAttractions.php' method='post' class="mt-auto">
											<input type='hidden' name='place_name'
												value='<?php echo htmlspecialchars($poi['name']) ?>'>
											<input type='hidden' name='place_address'
												value='<?php echo htmlspecialchars($poi['address']) ?>'>
											<input type='hidden' name='place_rating'
												value='<?php echo htmlspecialchars($poi['rating'] ?? 'N/A') ?>'>
											<input type='hidden' name='place_price'
												value='<?php echo number_format($poi['price'], 2) ?>'>
											<input type='hidden' name='place_id'
												value='<?php echo htmlspecialchars($poi['place_id']) ?>'>
											<div class="w-100 d-flex justify-content-between">
												<?php
												if ($isBooked) {
													echo "<button type='button' class='btn btn-secondary' disabled title='Already in cart'>Booked</button>";
												} else {
													echo "<button type='submit' class='btn btn-success'>Book</button>";
												}
												?>
												<a class='btn btn-primary'
													href="placeDetail.php?placeID=<?php echo $poi['place_id'] ?>">Detail</a>
											</div>
										</form>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>

				</div>
			</div>
			<div class="btn-container">
				<button class="cssbuttons-io-button" onclick="window.location.href='cart.php'">
					Go to cart
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 24 24"
							fill="currentColor">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path
								d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.82 14l.93-2h6.34l.93 2H20V6H6.31l-.95-2H2v2h2.31l3.6 7.59-1.35 2.44C6.02 17.37 6.48 18 7.11 18h12v-2H7.82z" />
						</svg>
					</div>
				</button>

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

</body>

</html>