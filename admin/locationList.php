<?php
session_start();
include 'fn_adminTelly.php';
include 'dbconnect.php';

$placeType = $_GET['placeType'];

$pageTitle = $placeType . " - TripTelly Admin";

if (!isset($_SESSION["adminID"])) {
    header("../index.php");
}

$adminData = fetchCurrentAdminData($_SESSION['adminID']);

// list of place location
$places = placeNameAndValue();

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
                // for testing purpose. comment when not use
                // var_dump($adminData)
                include "view_toaster.php";
                ?>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $placeType ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Product</li>
                        <li class="breadcrumb-item active"><?= $placeType ?></li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4><?= $placeType ?> List</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Location</th>
                                        <th>Sale</th>
                                        <th>Trip</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Location</th>
                                        <th>Sale</th>
                                        <th>Trip</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($places as $place) {
                                    ?>
                                    <tr>
                                        <td><?= $counter ?></td>
                                        <td><?= $place['name'] ?></td>
                                        <td>RM<?= number_format(calcTotalPriceWithDest($place['value']), 2) ?></td>
                                        <td><?= calcTripCountWithDest($place['value']) ?></td>
                                        <td>
                                            <div class="action-btn w-100 d-flex justify-content-evenly">
                                                <a href="locationDetail.php?placeType=<?= $placeType ?>&placeName=<?= $place['name'] ?>"
                                                    class="btn btn-info">Detail</a>

                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $counter++;
                                    }
                                    ?>
                                </tbody>
                            </table>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>