<?php
session_start();
$errors = [];
$success = "";

// Display errors or success messages from the session
if (!empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
if (!empty($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ASHKNIGHTS</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="form-header">
                <h1>Welcome Back</h1>
                <p>Log in to access your ASHKNIGHTS account and stay connected!</p>
            </div>

            <!-- Display Errors -->
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Display Success Message -->
            <?php if ($success): ?>
                <div class="success-message">
                    <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="actions/login_action.php" method="POST" class="login-form">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                
                <button type="submit" class="btn">Log In</button>
                
                <p class="redirect">
                    Don't have an account? <a href="signup.php">Sign Up</a>
                </p>
            </form>
        </div>

        <div class="right-section">
            <video autoplay muted loop>
                <source src="cd65b56e991c4ad8a8ffd672b5ec868c.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</body>
</html>
