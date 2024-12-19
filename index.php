<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASHKNIGHTS Basketball</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header class="hero">
        <nav class="navbar">
            <div class="logo">ASHKNIGHTS</div>
            <ul class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- If user is logged in -->
                    <li><a href="dashboard_admin.php" class="btn">Dashboard</a></li>
                    <li><a href="logout.php" class="btn signup">Logout</a></li>
                <?php else: ?>
                    <!-- If user is not logged in -->
                    <li><a href="login.php" class="btn">Login</a></li>
                    <li><a href="signup.php" class="btn signup">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="hero-content">
            <h1>Welcome to Ashknights Basketball</h1>
            <p>Join the Ashknights family and experience the thrill of basketball like never before. Stay connected with your team, track stats, and get the latest updates.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- Show signup button only when user is not logged in -->
                <a href="signup.php" class="btn signup">Sign Up</a>
            <?php else: ?>
                <a href="dashboard_admin.php" class="btn signup">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </header>
</body>
</html>
