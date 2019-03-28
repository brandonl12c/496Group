<?php
$servername = "localhost";
// MAMP password == "root", change to "" if using XAMPP
$username = "root";
$password = "root";
$dbname = "496db"; //dbname

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "//db connected test test test<br>";
?>