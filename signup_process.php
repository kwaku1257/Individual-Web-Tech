<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'ashknights');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
$position = $_POST['position'];

// Insert into database
$sql = "INSERT INTO users (fullname, email, password, position) VALUES ('$fullname', '$email', '$password', '$position')";

if ($conn->query($sql) === TRUE) {
    echo "Sign Up successful! <a href='login.html'>Log in here</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
