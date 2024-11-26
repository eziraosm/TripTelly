<?php
session_start();
include 'fn_adminTelly.php';
include 'dbconnect.php';
$pageTitle = "Customer";

if (!isset($_SESSION["adminID"])) {
    header("../index.php");
}

if (isset($_SESSION['deleteCustomerID'])) {
    unset($_SESSION['deleteCustomerID']);
}

$adminData = fetchCurrentAdminData($_SESSION['adminID']);

// datatable customer 
$allCustomer = fetchAllCustomerData();

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
                // var_dump($toastMessage)
                if (isset($_GET['deleteCustomerID'])) {
                    $delCustomerData = fetchCurrentCustomerData($_GET['deleteCustomerID']);
                    $_SESSION['delete_msg'] = $delCustomerData['username'] . " customer will be deleted.";
                    $_SESSION['deleteCustomerID'] = $_GET['deleteCustomerID'];
                    include "view_alertToaster.php";
                }
                if (isset($_SESSION['success_msg']) || isset($_SESSION['error_msg'])) {
                    include "view_toaster.php";
                }
                ?>

                <div class="container-fluid px-4">
                    <h1 class="mt-4">Customer</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active">Customer</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between">
                            <div class="table-title">
                                <i class="fas fa-table me-1"></i>
                                Customer List
                            </div>
                            <div class="register-btn">
                                <a href="customerRegister.php" class="btn btn-success">Register</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Full Name</th>
                                        <th>Short Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Admin ID</th>
                                        <th>Full Name</th>
                                        <th>Short Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($allCustomer as $data) {
                                        ?>
                                        <tr>
                                            <td><?php echo $data['userID'] ?></td>
                                            <td><?php echo $data['userFname'] ?></td>
                                            <td><?php echo $data['username'] ?></td>
                                            <td><?php echo $data['userEmail'] ?></td>
                                            <td>
                                                <div class="action-btn w-100 d-flex justify-content-evenly">
                                                    <a href="customerEdit.php?editCustomerID=<?php echo $data['userID'] ?>"
                                                        class="btn btn-info">Edit</a>

                                                    <button class="btn btn-danger"
                                                        onclick="window.location.href='customerList.php?deleteCustomerID=<?php echo $data['userID'] ?>'">Delete</button>

                                                </div>
                                            </td>
                                        </tr>
                                        <?php
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/scripts.js"></script>


</body>

</html>