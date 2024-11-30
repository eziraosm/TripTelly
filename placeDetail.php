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


$placeID = isset($_GET['placeID']) ? $_GET['placeID'] : null;
$placeData = fetchPlaceDetail($placeID);
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
					<li class="nav-item">
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
		<?php endif;
        // var_dump(json_encode($placeData));
        ?>


		<div class="detail-container p-5 w-100 ">
			<div class="detail-title">
				<h3>Attractions in <?php echo $destination ?></h3>
				<h5>Select places you would like to visit</h5>
			</div>
			<div class="hotel-table">
				
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