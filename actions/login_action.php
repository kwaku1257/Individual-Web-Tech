<?php
session_start();
include '../settings/connection.php'; // Include database connection

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validation
    if (empty($email) || empty($password)) {
        $errors[] = "Email and Password are required.";
    }

    // If no errors, process login
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, fullname, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user details in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: ../dashboard_admin.php");
                } else {
                    header("Location: ../dashboard.php");
                }
                exit();
            } else {
                $errors[] = "Invalid email or password.";
            }
        } else {
            $errors[] = "No account found with this email.";
        }
        $stmt->close();
    }

    // Store errors in session and redirect back
    $_SESSION['errors'] = $errors;
    header("Location: ../login.php");
    exit();
} else {
    header("Location: ../login.php");
    exit();
}
?>
