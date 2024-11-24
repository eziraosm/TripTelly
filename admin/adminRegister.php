<?php
session_start();
include 'fn_adminTelly.php';
include 'dbconnect.php';

if (!isset($_SESSION["adminID"])) {
    header("../index.php");
}

$adminData = fetchCurrentAdminData($_SESSION['adminID']);

?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register Admin - TripTelly Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                ?>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Register Admin</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item">Admin</li>
                        <li class="breadcrumb-item active">Register Admin</li>
                    </ol>
                    <div class="card mb-4 ">
                        <div class="card-header">
                            <h4>Admin Registration Form</h4>
                        </div>
                        <div class="card-body">
                            <form action="fn_adminRegister.php" method="POST">
                                <!-- Short Name -->
                                <div class="mb-3">
                                    <label for="adminName" class="form-label">Short Name</label>
                                    <input type="text" name="adminName" id="adminName" class="form-control"
                                        placeholder="Enter short name" required />
                                </div>
                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="adminFName" class="form-label">Full Name</label>
                                    <input type="text" name="adminFName" id="adminFName" class="form-control"
                                        placeholder="Enter full name" required />
                                </div>
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="adminEmail" class="form-label">Email</label>
                                    <input type="email" name="adminEmail" id="adminEmail" class="form-control"
                                        placeholder="Enter email address" required />
                                </div>
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="adminPassword" class="form-label">Password</label>
                                    <input type="password" name="adminPassword" id="adminPassword" class="form-control"
                                        placeholder="Enter password" required />
                                </div>
                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirmPassword" id="confirmPassword"
                                        class="form-control" placeholder="Confirm your password" required />
                                </div>
                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Register</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
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
</body>

</html>