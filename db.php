<?php
$host = "localhost";
$username = "root";
$password = "root";
$database = "restaurant_queue";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->set_charset("utf8");

echo "Database connection successful!";
?>
