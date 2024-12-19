<?php
session_start();
include '../settings/connection.php';

// Ensure only admins can perform this action
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: ../dashboard_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $match_id = $_POST['match_id'];
    $title = trim($_POST['match_title']);
    $location = trim($_POST['match_location']);
    $match_time = $_POST['match_time'];

    if (empty($match_id) || empty($title) || empty($location) || empty($match_time)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../dashboard_admin.php");
        exit();
    }

    // Update query
    $stmt = $conn->prepare("UPDATE matches SET title=?, location=?, match_time=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $location, $match_time, $match_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Match updated successfully.";
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
