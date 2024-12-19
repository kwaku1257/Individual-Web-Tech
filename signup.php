<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - ASHKNIGHTS</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="form-header">
                <h1>Join ASHKNIGHTS</h1>
                <p>Sign up to become part of our basketball community and stay connected!</p>
            </div>

            <?php 
            session_start();
            if (!empty($_SESSION['errors'])): ?>
                <div class="error-messages">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; 
                    unset($_SESSION['errors']); // Clear errors after display
                    ?>
                </div>
            <?php endif; ?>

            <form action="actions/signup_action.php" method="POST" class="signup-form">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
                
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                
                <label for="role">Select Role</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                
                <button type="submit" class="btn">Sign Up</button>
                
                <p class="redirect">
                    Already have an account? <a href="login.php">Log In</a>
                </p>
            </form>
        </div>

        <div class="right-section">
            <video autoplay muted loop>
                <source src="b2bc712fbba9444580a1ee7980be4936.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</body>
</html>
