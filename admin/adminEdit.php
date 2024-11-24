<?php
session_start();
include 'fn_adminTelly.php';
include 'dbconnect.php';
// always put this
$pageTitle = "Update Admin";

if (!isset($_SESSION["adminID"])) {
    header("../index.php");
}

$adminData = fetchCurrentAdminData($_SESSION['adminID']);

if (isset($_GET['editAdminID'])) {
    $editAdminID = $_GET['editAdminID'];
    $editAdminData = fetchCurrentAdminData($editAdminID);
}
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
                    <h1 class="mt-4"><?php echo $pageTitle ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item">Admin</li>
                        <li class="breadcrumb-item active"><?php echo $pageTitle ?></li>
                    </ol>
                    <div class="card mb-4 ">
                        <div class="card-header">
                            <h4>Admin Update Form</h4>
                        </div>
                        <div class="card-body">
                            <form action="fn_adminEdit.php" method="POST">
                                <!-- Short Name -->
                                <div class="mb-3">
                                    <label for="adminName" class="form-label">Short Name</label>
                                    <input type="text" name="adminName" id="adminName" class="form-control"
                                        placeholder="Enter short name" required autocomplete="off" 
                                        value="<?php echo $editAdminData['adminName'] ?>" />
                                </div>
                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="adminFName" class="form-label">Full Name</label>
                                    <input type="text" name="adminFName" id="adminFName" class="form-control"
                                        placeholder="Enter full name" required autocomplete="off"
                                        value="<?php echo $editAdminData['adminFname'] ?>" />
                                </div>
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="adminEmail" class="form-label">Email</label>
                                    <input type="email" name="adminEmail" id="adminEmail" class="form-control"
                                        placeholder="Enter email address" required autocomplete="off"
                                        value="<?php echo $editAdminData['adminEmail'] ?>" />
                                </div>
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="adminPassword" class="form-label">Password</label>
                                    <input type="password" name="adminPassword" id="adminPassword" class="form-control"
                                        placeholder="Enter password" required autocomplete="off"
                                        value="<?php echo $editAdminData['adminPassword'] ?>" />
                                </div>
                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirmPassword" id="confirmPassword"
                                        class="form-control" placeholder="Confirm your password" required
                                        autocomplete="off" value="<?php echo $editAdminData['adminPassword'] ?>" />
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