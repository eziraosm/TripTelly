<?php
session_start();
include 'fn_adminTelly.php';
include 'dbconnect.php';
$pageTitle = "Hotel - TripTelly Admin";

if (!isset($_SESSION["adminID"])) {
    header("../index.php");
}

$adminData = fetchCurrentAdminData($_SESSION['adminID']);

// list of place location
$places = [
    ['value' => 'johor', 'name' => 'Johor'],
    ['value' => 'kedah', 'name' => 'Kedah'],
    ['value' => 'kelantan', 'name' => 'Kelantan'],
    ['value' => 'melaka', 'name' => 'Melaka'],
    ['value' => 'negeri sembilan', 'name' => 'Negeri Sembilan'],
    ['value' => 'pahang', 'name' => 'Pahang'],
    ['value' => 'penang', 'name' => 'Penang'],
    ['value' => 'perak', 'name' => 'Perak'],
    ['value' => 'perlis', 'name' => 'Perlis'],
    ['value' => 'selangor', 'name' => 'Selangor'],
    ['value' => 'terengganu', 'name' => 'Terengganu'],
    ['value' => 'kuala lumpur', 'name' => 'Wilayah Persekutuan Kuala Lumpur'],
    ['value' => 'labuan', 'name' => 'Wilayah Persekutuan Labuan'],
    ['value' => 'putrajaya', 'name' => 'Wilayah Persekutuan Putrajaya'],
];


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
                    <h1 class="mt-4">Hotel</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Product</li>
                        <li class="breadcrumb-item active">Hotel</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Hotel List</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Location</th>
                                        <th>Hotel Numbers</th>
                                        <th>Sale</th>
                                        <th>Trip</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Location</th>
                                        <th>Hotel Numbers</th>
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
                                        <td>test</td>
                                        <td>etst</td>
                                        <td>test</td>
                                        <td>
                                            <div class="action-btn w-100 d-flex justify-content-evenly">
                                                <a href="locationDetail.php?locationName="
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