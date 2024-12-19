<?php
$host = "localhost";
$user = "kwaku.asare";  
$password = "ericShirl4"; 
$database = "webtech_fall2024_kwaku_asare";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
