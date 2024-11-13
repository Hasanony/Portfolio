<?php
$servername = "localhost";
$username = "root";  // Change as per your MySQL username
$password = "";      // Change as per your MySQL password
$dbname = "portfolio";    // Database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
