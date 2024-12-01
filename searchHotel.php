<?php
session_start();
include 'dbconnect.php';
include 'fn_triptelly.php';

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

// Handle AJAX request to set error message in the session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = json_decode(file_get_contents('php://input'), true);
	if (isset($data['set_error_msg']) && $data['set_error_msg']) {
		$_SESSION['error_msg'] = 'You can only book one hotel.  Please delete hotel from cart if you would like to change hotel.';
		echo json_encode(['status' => 'success']);
		exit();
	}
}

if (isset($_SESSION['userID'])) {
	$userID = $_SESSION['userID'];

	// Fetch the cartID associated with this user
	$cartQuery = "SELECT cartID FROM cart WHERE userID = ?";
	$stmt = $conn->prepare($cartQuery);
	$stmt->bind_param("s", $userID);
	$stmt->execute();
	$result = $stmt->get_result();

	$userCarts = [];
	while ($row = $result->fetch_assoc()) {
		$userCarts[] = $row['cartID'];
		$_SESSION['cartID'] = $row['cartID'];
	}

	// Check if any hotel is already booked
	$hasBookedHotel = false;
	if (!empty($userCarts)) {
		$cartPlaceholders = implode(',', array_fill(0, count($userCarts), '?'));
		$cartHotelQuery = "SELECT COUNT(*) AS bookedCount FROM cart_hotel WHERE cartID IN ($cartPlaceholders)";
		$stmt = $conn->prepare($cartHotelQuery);
		$stmt->bind_param(str_repeat('s', count($userCarts)), ...$userCarts);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($row = $result->fetch_assoc()) {
			$hasBookedHotel = $row['bookedCount'] > 0;
		}
	}
} else {
	// Redirect user to login page if not authenticated
	header("Location: login.php");
	exit();
}

// Check if hotel data exists in the session
if (!isset($_SESSION['hotel_data'])) {
	echo "No search results found.";
	exit();
}

$hotel_data = $_SESSION['hotel_data'];
$form_data = $_SESSION['form_data'];
$max_budget = isset($_SESSION['max_budget']) ? $_SESSION['max_budget'] : $form_data["max_budget"];
$destination = isset($_SESSION['destination'])
	? $_SESSION['destination']
	: (isset($form_data["destinationLocation"])
		? $form_data["destinationLocation"]
		: (isset($form_data["destination_loc"])
			? $form_data["destination_loc"]
			: null));

// change sticky container if over budget
if (getTotalCartPrice() > $max_budget) {
	$stickyClass = "over-budget";
} else {
	$stickyClass = "price-display";
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
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>

	<!--style.css-->
	<link rel="stylesheet" href="assets/css/custom.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
		integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<title>Hotel Result</title>
	<link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />
	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
		integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
		crossorigin="anonymous"></script>
	<link rel="stylesheet" href="assets/css/searchResult.css">
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
			<ul class="navbar-nav mr-auto" style="margin-left:10px">
				<li class="nav-item active">
					<a class="nav-link" href="searchHotel.php">Hotels <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="searchAttractions.php">Attractions</a>
				</li>
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
				<button type="button" class="btn btn-secondary"
					onclick="window.location.href='fn_signout.php'"><?php echo htmlspecialchars($username) ?></button>
			</div>
		</div>
	</nav>
	<div class="sticky-container">
		<div class="<?php echo $stickyClass ?>">
			<div class="current-display">
				Current: <span class="price">RM <?php echo number_format(getTotalCartPrice(), 2) ?></span>
			</div>
			<div class="budget-display">
				Budget: <span class="price"> RM <?php echo number_format($max_budget, 2) ?></span>
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
				<h3>Hotels in <?php echo $destination ?></h3>
				<h5>Select accommodations within your budget</h5>
			</div>
			<div class="hotel-table">
				<div class="container my-4">
					<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 justify-content-center">
						<?php
						foreach ($hotel_data as $key => $hotel) {
							?>
							<div class="col">
								<div class="card h-100 d-flex flex-column">
									<img src="<?php echo htmlspecialchars($hotel['photo_url']); ?>"
										class="card-img-top img-fluid object-fit-cover" style="height: 200px;"
										alt="Hotel Image">
									<div class="card-body d-flex flex-column">
										<h6 class="card-title"><?php echo $hotel["name"] ?></h6>
										<p class="card-text"><?php echo htmlspecialchars($hotel['address']); ?></p>
										<div
											class="price-rating w-100 d-flex justify-content-between align-items-center mt-auto">
											<p>RM <?php echo htmlspecialchars($hotel['price']); ?></p>
											<p>
												<?php echo htmlspecialchars($hotel['rating']); ?>
												<i class='bx bxs-star'></i>
											</p>
										</div>
										<form action='fn_bookHotel.php' method='post' class="mt-auto">
											<input type='hidden' name='hotel_name'
												value='<?php echo htmlspecialchars($hotel['name']) ?>'>
											<input type='hidden' name='hotel_address'
												value='<?php echo htmlspecialchars($hotel['address']) ?>'>
											<input type='hidden' name='hotel_rating'
												value='<?php echo htmlspecialchars($hotel['rating'] ?? 'N/A') ?>'>
											<input type='hidden' name='hotel_price'
												value='<?php echo number_format($hotel['price'], 2) ?>'>
											<input type='hidden' name='place_id'
												value='<?php echo htmlspecialchars($hotel['place_id']) ?>'>
											<div class="w-100 d-flex justify-content-between">
												<?php
												if ($hasBookedHotel) {
													echo "<button type='button' class='btn btn-secondary booked-btn'
                            							title='You can only book one hotel'>Booked</button>"
													;
												} else {
													echo "<button type='submit' class='btn btn-success'>Book</button>";
												}
												?>
												<a class='btn btn-primary'
													href="placeDetail.php?placeID=<?php echo $hotel['place_id'] ?>">Detail</a>
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
				<button class="cssbuttons-io-button" onclick="window.location.href='searchAttractions.php'">
					Next
					<div class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
								fill="currentColor"></path>
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
			// Handle "Booked" button click
			document.querySelectorAll('.booked-btn').forEach(button => {
				button.addEventListener('click', () => {
					// Send an AJAX request to update the session error message
					fetch(window.location.href, {
						method: 'POST',
						body: JSON.stringify({ set_error_msg: true }),
						headers: {
							'Content-Type': 'application/json'
						}
					})
						.then(response => response.json())
						.then(data => {
							if (data.status === 'success') {
								// Reload the page to show the toast message
								location.reload();
							}
						})
						.catch(error => console.error('Error:', error));
				});
			});

			// Show toast message if available
			var toastEl = document.getElementById('liveToast');
			if (toastEl) {
				var toast = new bootstrap.Toast(toastEl);
				toast.show();
			}
		});
	</script>

</body>

</html>