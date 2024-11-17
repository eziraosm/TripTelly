<?php
session_start();
include 'dbconnect.php';
include 'fn_triptelly.php';

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
if (!isset($_SESSION['hotel_data'])) {
	echo "No search results found.";
	exit();
}

$hotel_data = $_SESSION['hotel_data']; 
$form_data = $_SESSION['form_data'];
$max_budget = $_SESSION['max_budget'];
$destination = $_SESSION['destination'];

// Function to generate random price up to maxHotelPrice

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
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
		integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
		integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
		crossorigin="anonymous"></script>
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
		<div class="container">
			<div class="title">
				<h3>Hotels in <?php echo $destination ?></h3>
				<h5>Select accommodations within your budget</h5>
			</div>
			<div class="hotel-table">
				<table class="table table-hover table-dark">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Hotel Name</th>
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
						foreach ($hotel_data as $hotel) {

							echo "<tr>";
							echo "<td scope='row'>{$count}</td>";
							echo "<td>" . htmlspecialchars($hotel['name']) . "</td>";
							echo "<td>" . htmlspecialchars($hotel['address']) . "</td>";
							echo "<td>" . htmlspecialchars($hotel['rating'] ?? 'N/A') . "</td>";
							echo "<td>RM " . number_format($hotel['price'], 2) . "</td>";
							echo "<td><a href='https://www.google.com/maps/search/?api=1&query=" . urlencode($hotel['name']) . "' target='_blank'><button class='btn btn-primary'>GMap</button></a></td>";
							echo "<td>
										<form action='fn_bookHotel.php' method='post'>
											<input type='hidden' name='hotel_name' value='" . htmlspecialchars($hotel['name']) . "'>
											<input type='hidden' name='hotel_address' value='" . htmlspecialchars($hotel['address']) . "'>
											<input type='hidden' name='hotel_rating' value='" . htmlspecialchars($hotel['rating'] ?? 'N/A') . "'>
											<input type='hidden' name='hotel_price' value='" . number_format($hotel['price'], 2) . "'>
											<input type='hidden' name='place_id' value='" . htmlspecialchars($hotel['place_id']) . "'>
											<button type='submit' class='btn btn-success'>Book</button>
										</form>
									</td>";
							echo "</tr>";

							$count++;
							if ($count > 10)
								break; // Limit to 20 hotels
						}
						if ($count == 1) {
							echo "<tr><td colspan='8'>No hotels found within your budget.</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</main>
</body>

</html>