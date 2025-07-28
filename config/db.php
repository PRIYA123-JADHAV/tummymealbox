<?php
$host = "localhost";
$user = "root";
$pass = ""; // usually blank in XAMPP
$dbname = "krispy";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
