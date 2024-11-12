<?php
session_start(); 
include 'dbconnect.php';

if (isset($_SESSION['userID'])) {
	
	$userID = $_SESSION['userID'];
	$userDataQuery = "SELECT * FROM USER WHERE userID = ?";
	$stmt = $conn -> prepare(query: $userDataQuery);
	$stmt -> bind_param("s", $userID);
	$stmt -> execute();
	$result = $stmt -> get_result();

	if ($result -> num_rows > 0) {
		$userData = $result -> fetch_assoc();
		$username = $userData['username'];
	}else {
		$username = null;
	}
}
?>


<!DOCTYPE html>
<html class="no-js"  lang="en">

	<head>
		<!-- META DATA -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<!--font-family-->
		<link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet" />

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet" />

		<!-- TITLE OF SITE -->
		<title>Travel</title>

		<!-- favicon img -->
		<link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>

		<!--font-awesome.min.css-->
		<link rel="stylesheet" href="assets/css/font-awesome.min.css" />

		<!--animate.css-->
		<link rel="stylesheet" href="assets/css/animate.css" />

		<!--hover.css-->
		<link rel="stylesheet" href="assets/css/hover-min.css">

		<!--datepicker.css-->
		<link rel="stylesheet"  href="assets/css/datepicker.css" >

		<!--owl.carousel.css-->
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="assets/css/owl.theme.default.min.css"/>

		<!-- range css-->
        <link rel="stylesheet" href="assets/css/jquery-ui.min.css" />

		<!--bootstrap.min.css-->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />

		<!-- bootsnav -->
		<link rel="stylesheet" href="assets/css/bootsnav.css"/>

		<!--style.css-->
		<link rel="stylesheet" href="assets/css/custom.css">
		<link rel="stylesheet" href="assets/css/style.css" />

		<!--responsive.css-->
		<link rel="stylesheet" href="assets/css/responsive.css" />


		<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>
		
		<header class="top-area">
			<div class="header-area">
				<div class="container">
					<div class="row">
						<div class="col-sm-2">
							<div class="logo">
								<a href="index.php">
									trip<span>Telly</span>
								</a>
							</div><!-- /.logo-->
						</div><!-- /.col-->
						<div class="col-sm-10">
							<div class="main-menu">
							
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
										<i class="fa fa-bars"></i>
									</button><!-- / button-->
								</div><!-- /.navbar-header-->
								<div class="collapse navbar-collapse">		  
									<ul class="nav navbar-nav navbar-right">
										<li>
											<button class="cart-btn">
												<i class="bx bxs-cart"></i>
											</button>
										</li>
										<li>
										<?php
											if (isset($_SESSION['userID']) && isset($username)) {
												echo '<button class="book-btn" onclick="window.location.href = \'fn_signout.php\'">' . htmlspecialchars($username) . '</button>';
											} else {
												echo '<button class="book-btn" onclick="window.location.href = \'signin.php\'">Sign In</button>';
											}
										?>
										</li><!--/.project-btn--> 
									</ul>
								</div><!-- /.navbar-collapse -->
							</div><!-- /.main-menu-->
						</div><!-- /.col-->
					</div><!-- /.row -->
					<div class="home-border"></div><!-- /.home-border-->
				</div><!-- /.container-->
			</div><!-- /.header-area -->

		</header><!-- /.top-area-->
		<!-- main-menu End -->

		
		<!--about-us start -->
		<section id="home">
			<div class="result">
				<div class="bus-container">
					<div class="table-title">
						<h3>Bus Trip List</h3>
					</div>
					<div class="origin-dest-container">
						<h4>Kuala Lumpur</h4> <i class="bx bx-right-arrow-alt"></i> <h4>Kelantan</h4>
					</div>
					<div class="table-container">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">Bus Name</th>
								<th scope="col">Station</th>
								<th scope="col">Departure Time</th>
								<th scope="col">Arrival Time</th>
								<th scope="col">Price</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td scope="row">1</td>
								<td>SuperBus Express</td>
								<td>Kuala Lumpur</td>
								<td>08:00 AM</td>
								<td>12:00 PM</td>
								<td>RM 35</td>
								<td><button>Book</button></td>
							</tr>
							<tr>
								<td scope="row">2</td>
								<td>Golden Coach</td>
								<td>Penang</td>
								<td>09:30 AM</td>
								<td>02:00 PM</td>
								<td>RM 45</td>
								<td><button>Book</button></td>
							</tr>
							<tr>
								<td scope="row">3</td>
								<td>CityLink Bus</td>
								<td>Johor Bahru</td>
								<td>10:00 AM</td>
								<td>02:30 PM</td>
								<td>RM 50</td>
								<td><button>Book</button></td>
							</tr>
							<tr>
								<td scope="row">4</td>
								<td>ExpressWay Travels</td>
								<td>Melaka</td>
								<td>11:15 AM</td>
								<td>03:00 PM</td>
								<td>RM 25</td>
								<td><button>Book</button></td>
							</tr>
							<tr>
								<td scope="row">5</td>
								<td>Comfort Bus</td>
								<td>Ipoh</td>
								<td>01:00 PM</td>
								<td>04:30 PM</td>
								<td>RM 40</td>
								<td><button>Book</button></td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</section><!--/.about-us-->
		<!--about-us end -->

		<!-- footer-copyright start -->
		<footer  class="footer-copyright">
			<div class="container">
				
				<hr>
				<div class="foot-icons ">
					<ul class="footer-social-links list-inline list-unstyled">
		                <li><a href="#" target="_blank" class="foot-icon-bg-1"><i class="fa fa-facebook"></i></a></li>
		                <li><a href="#" target="_blank" class="foot-icon-bg-2"><i class="fa fa-twitter"></i></a></li>
		                <li><a href="#" target="_blank" class="foot-icon-bg-3"><i class="fa fa-instagram"></i></a></li>
		        	</ul>
		        	<p>&copy; 2017 <a href="https://www.themesine.com">ThemeSINE</a>. All Right Reserved</p>

		        </div><!--/.foot-icons-->
				<div id="scroll-Top">
					<i class="fa fa-angle-double-up return-to-top" id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
				</div><!--/.scroll-Top-->
			</div><!-- /.container-->

		</footer><!-- /.footer-copyright-->
		<!-- footer-copyright end -->




		<script src="assets/js/jquery.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->

		<!--modernizr.min.js-->
		<script  src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>


		<!--bootstrap.min.js-->
		<script  src="assets/js/bootstrap.min.js"></script>

		<!-- bootsnav js -->
		<script src="assets/js/bootsnav.js"></script>

		<!-- jquery.filterizr.min.js -->
		<script src="assets/js/jquery.filterizr.min.js"></script>

		<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

		<!--jquery-ui.min.js-->
        <script src="assets/js/jquery-ui.min.js"></script>

        <!-- counter js -->
		<script src="assets/js/jquery.counterup.min.js"></script>
		<script src="assets/js/waypoints.min.js"></script>

		<!--owl.carousel.js-->
        <script  src="assets/js/owl.carousel.min.js"></script>

        <!-- jquery.sticky.js -->
		<script src="assets/js/jquery.sticky.js"></script>

        <!--datepicker.js-->
        <script  src="assets/js/datepicker.js"></script>

		<!--Custom JS-->
		<script src="assets/js/custom.js"></script>

		<script>
			document.getElementById("scrollButton").addEventListener("click", function() {
				let totalScrollDistance = 700; // Total pixels to scroll down (100 pixels x 7 times)
				let scrollStep = 5;  // Small increments of pixels for smooth scrolling
				let currentScroll = 0;  // Tracks how much has been scrolled

				function smoothScroll() {
					if (currentScroll < totalScrollDistance) {
						window.scrollBy(0, scrollStep);
						currentScroll += scrollStep;
						requestAnimationFrame(smoothScroll);  // Continue smooth scrolling
					}
				}

				requestAnimationFrame(smoothScroll);  // Start smooth scrolling
			});
		</script>
	</body>

</html>