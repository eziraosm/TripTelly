<?php
session_start();
include "dbconnect.php";

if (isset($_SESSION['userID'])) {

	$userID = $_SESSION['userID'];
	$userDataQuery = "SELECT * FROM USER WHERE userID = ?";
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

// Check if hotel data exists in the session
if (!isset($_SESSION['attraction_data'])) {
	echo "No search results found.";
	exit();
}

$form_data = $_SESSION['form_data'];
$attraction_data = $_SESSION['attraction_data'];

$attraction_budget = $form_data['max_budget'] * 0.6;

function generateRandomPrice($maxAttractionBudget)
{
	// 5% chance to exceed 100
	if (rand(1, 100) <= 10) {
		// Ensure the price is more than 100 but within the maximum budget
		return rand(101, $maxAttractionBudget);
	}

	// Otherwise, return a regular price between 3 and 100
	return rand(3, min(100, $maxAttractionBudget));
}

// toast controller
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
				<h3>Attractions in <?php echo $form_data['destination_loc'] ?></h3>
				<h5>Select places you would like to visit</h5>
			</div>
			<div class="hotel-table">
				<table class="table table-hover table-dark">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Place Name</th>
							<th scope="col">Location</th>
							<th scope="col">Ratings</th>
							<th scope="col">Price</th>
							<th scope="col">Map</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 1;
						foreach ($attraction_data as $poi) {
							$price = generateRandomPrice($attraction_budget);

							echo "<tr>";
							echo "<td scope='row'>{$count}</td>";
							echo "<td>" . htmlspecialchars($poi['name']) . "</td>";
							echo "<td>" . htmlspecialchars($poi['address']) . "</td>";
							echo "<td>" . htmlspecialchars($poi['rating'] ?? 'N/A') . "</td>";
							echo "<td>RM " . number_format($price, 2) . "</td>";
							echo "<td><a href='https://www.google.com/maps/search/?api=1&query=" . urlencode($poi['name']) . "' target='_blank'><button class='btn btn-primary'>GMap</button></a></td>";
							echo "<td>
										<form action='fn_bookAttractions.php' method='post'>
											<input type='hidden' name='place_name' value='" . htmlspecialchars($poi['name']) . "'>
											<input type='hidden' name='place_address' value='" . htmlspecialchars($poi['address']) . "'>
											<input type='hidden' name='place_rating' value='" . htmlspecialchars($poi['rating'] ?? 'N/A') . "'>
											<input type='hidden' name='place_price' value='" . number_format($price, 2) . "'>
											<input type='hidden' name='place_id' value='" . htmlspecialchars($poi['place_id']) . "'>
											<button type='submit' class='btn btn-success'>Book</button>
										</form>
									</td>";
							echo "</tr>";

							$count++;
						}
						if ($count == 1) {
							echo "<tr><td colspan='8'>No hotels found within your budget.</td></tr>";
						}
						?>
					</tbody>
				</table>
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