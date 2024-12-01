<?php
// $hostname = "localhost";
// $user = "root";
// $password = "";
// $database = "triptelly";

// $conn = mysqli_connect($hostname, $user, $password, $database) or DIE("Connection failed!");

// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
?>

<?php
$hostname = "usamahthani.com";
$user = "usamahthani_host";
$password = "Oh8{H0C=i!Vv";
$database = "usamahthani_triptelly";

$conn = mysqli_connect($hostname, $user, $password, $database) or DIE("Connection failed!");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>