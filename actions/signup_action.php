<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = [];

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Database Connection
include '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $role = $_POST['role'];

    // Validation
    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)) {
        $errors[] = "All fields are required.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullname, $email, $hashedPassword, $role);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Registration successful.";
                header("Location: ../login.php");
                exit();
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
        }
        $stmt->close();
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../signup.php");
        exit();
    }
} else {
    header("Location: ../signup.php");
    exit();
}
?>