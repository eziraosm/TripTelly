<?php
session_start();
include 'fn_adminTelly.php';
include 'dbconnect.php';
// always put this
$pageTitle = "Update Customer";

if (!isset($_SESSION["adminID"])) {
    header("../index.php");
}

$adminData = fetchCurrentAdminData($_SESSION['adminID']);

if (isset($_GET['editCustomerID'])) {
    $editCustomerID = $_GET['editCustomerID'];
    $editCustomerData = fetchCurrentCustomerData($editCustomerID);
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
                        <li class="breadcrumb-item">Customer</li>
                        <li class="breadcrumb-item active"><?php echo $pageTitle ?></li>
                    </ol>
                    <div class="card mb-4 ">
                        <div class="card-header">
                            <h4>Update Customer <?php echo $editCustomerData['username'] ?> Account </h4>
                        </div>
                        <div class="card-body">
                            <form action="fn_customerEdit.php" method="POST">
                                <!-- Short Name -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Short Name</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        placeholder="Enter short name"  autocomplete="off" 
                                        value="<?php echo $editCustomerData['username'] ?>" />
                                </div>
                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="userFName" class="form-label">Full Name</label>
                                    <input type="text" name="userFName" id="userFName" class="form-control"
                                        placeholder="Enter full name"  autocomplete="off"
                                        value="<?php echo $editCustomerData['userFname'] ?>" />
                                </div>
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="userEmail" class="form-label">Email</label>
                                    <input type="email" name="userEmail" id="userEmail" class="form-control"
                                        placeholder="Enter email address"  autocomplete="off"
                                        value="<?php echo $editCustomerData['userEmail'] ?>" />
                                </div>
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="userPassword" class="form-label">Password</label>
                                    <input type="password" name="userPassword" id="userPassword" class="form-control"
                                        placeholder="Enter password"  autocomplete="off" />
                                </div>
                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirmPassword" id="confirmPassword"
                                        class="form-control" placeholder="Confirm your password" 
                                        autocomplete="off" />
                                </div>
                                <input type="text" name="userID" value="<?php echo $editCustomerID ?>" hidden/>
                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Update</button>
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