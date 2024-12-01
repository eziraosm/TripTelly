<?php
session_start();
include 'fn_adminTelly.php';
include 'dbconnect.php';
$pageTitle = "Attractions - TripTelly Admin";

if (!isset($_SESSION["adminID"])) {
    header("../index.php");
}

$adminData = fetchCurrentAdminData($_SESSION['adminID']);

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
                    <h1 class="mt-4">Attraction</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Product</li>
                        <li class="breadcrumb-item active">Attraction</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Attraction List</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Location</th>
                                        <th>Attraction Numbers</th>
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
                                    // foreach ($allCustomer as $data) {
                                    ?>
                                    <tr>
                                        <td>test</td>
                                        <td>test</td>
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
                                    // }
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