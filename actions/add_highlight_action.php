<?php
session_start();
include '../settings/connection.php'; // Include database connection

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure only admins can perform this action
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: ../dashboard_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['highlight_title']);
    $description = trim($_POST['highlight_description']);
    $image = $_FILES['highlight_image'];
    $uploaded_by = 2; // Logged-in admin ID

    // Validate inputs
    if (empty($title) || empty($description) || $image['error'] != 0) {
        $_SESSION['error'] = "All fields are required, and a valid image must be uploaded.";
        header("Location: ../dashboard_admin.php");
        exit();
    }

    // Handle image upload
    $targetDirectory = "../uploads/";
    $imageName = time() . '_' . basename($image['name']); // Generate a unique image name
    $targetFilePath = $targetDirectory . $imageName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Allowed file formats
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        $_SESSION['error'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: ../dashboard_admin.php");
        exit();
    }

    // Move uploaded file
    if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
        // Set the video_path as the image path (CHANGED)
        $videoPath = $imageName; // Use the uploaded image name as the video_path

        // Insert into database (CHANGED)
        $stmt = $conn->prepare("INSERT INTO highlights (title, description, image, video_path, uploaded_by, uploaded_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }

        // Bind video_path dynamically (CHANGED)
        $stmt->bind_param("ssssi", $title, $description, $imageName, $videoPath, $uploaded_by);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Highlight added successfully.";
        } else {
            $_SESSION['error'] = "Database execution error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to upload the image.";
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the dashboard
header("Location: ../dashboard_admin.php");
exit();
?>