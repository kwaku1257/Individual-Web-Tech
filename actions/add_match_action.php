<?php
include '../settings/connection.php'; // Database connection file
session_start();


// Ensure only admins can perform this action
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: ../dashboard_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['match_title']);
    $location = trim($_POST['match_location']);
    $match_time = $_POST['match_time'];
    $created_by = $_SESSION['user_name'];

    // Validate inputs
    if (empty($title) || empty($location) || empty($match_time)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../dashboard_admin.php");
        exit();
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO matches (title, location, match_time, created_by, created_at) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
    $stmt->bind_param("ssss", $title, $location, $match_time, $created_by);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Match added successfully.";
    } else {
        $_SESSION['error'] = "Database error: " . $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

header("Location: ../dashboard_admin.php");
exit();
?>
