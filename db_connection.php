<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookiebike";

$connection = mysqli_connect($servername, $username, $password);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select the database
if (!mysqli_select_db($connection, $dbname)) {
    die("Database selection failed: " . mysqli_error($connection));
}
?>
