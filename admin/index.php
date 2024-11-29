<?php
session_start();
include 'fn_adminTelly.php';
include 'dbconnect.php';
$pageTitle = "Dashboard";

if (!isset($_SESSION["adminID"])) {
    header("../index.php");
}

$adminData = fetchCurrentAdminData($_SESSION['adminID']);

$allCartBook = fetchCartAndBook();

?>
<html lang="en">

<head>
    <?php include "view_head.php" ?>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <?php include "view_adminNavbar.php" ?>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include "view_adminSidebar.php" ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <?php
                // for test purpose. comment if not use
                // var_dump($allCartBook); 
                ?>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body" id="visitorCount">Loading...</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="small text-white stretched-link">Total User Visits</span>
                                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body" id="popularLocation">Loading...</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="small text-white stretched-link">Top Destination</span>
                                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body" id="salesCount">Loading...</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="small text-white stretched-link">Total Sales This Week</span>
                                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body" id="bookingCount">Loading...</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="small text-white stretched-link">Total Bookings</span>
                                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Number of Bookings
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Total Sales By Month
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            List of Bookings
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>User Name</th>
                                        <th>From Location</th>
                                        <th>Destination</th>
                                        <th>Departure Date</th>
                                        <th>Return Date</th>
                                        <th>Persons</th>
                                        <th>Total Cost (RM)</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>User Name</th>
                                        <th>From Location</th>
                                        <th>Destination</th>
                                        <th>Departure Date</th>
                                        <th>Return Date</th>
                                        <th>Persons</th>
                                        <th>Total Cost (RM)</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                    $counter = 1;
                                    foreach($allCartBook as $data) {
                                    ?>
                                    <tr>
                                        <td><?php echo $counter ?></td>
                                        <td><?php echo $data['userName'] ?></td>
                                        <td><?php echo ucwords($data['fromLocation'])  ?></td>
                                        <td><?php echo ucwords($data['destinationLocation']) ?></td>
                                        <td><?php echo $data['departureDate'] ?></td>
                                        <td><?php echo $data['returnDate'] ?></td>
                                        <td><?php echo $data['person'] ?></td>
                                        <td><?php echo $data['totalPrice'] ?? "Counting..." ?></td>
                                        <td><?php echo $data['status'] ?></td>
                                    </tr>
                                    <?php
                                    $counter++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <?php include "view_adminFooter.php" ?>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <?php include "view_areaChart.php"; ?>
    <?php include "view_barChart.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/ajax-dashboardBox.js"></script>
</body>
</html>