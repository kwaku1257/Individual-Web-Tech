<?php
session_start();
include 'settings/connection.php'; // Database connection file

// Ensure only admins can access this page
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch highlights and matches from the database
// $highlights = $conn->query("SELECT * FROM highlights");
// $matches = $conn->query("SELECT * FROM matches");

$highlightsQuery = $conn->query("SELECT title, description, image FROM highlights ORDER BY uploaded_at DESC");
if (!$highlightsQuery) {
    die("Error fetching highlights: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ASHKNIGHTS</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
    .highlight-list {
        margin: 20px 0;
    }

    .highlight-item {
        margin-bottom: 20px;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .highlight-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .highlight-item h3 {
        margin: 0 0 5px;
        font-size: 18px;
    }

    .highlight-item p {
        margin: 0;
        color: #555;
    }
</style>

</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">ASHKNIGHTS</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="highlights.html">Highlights</a></li>
                    <li><a href="schedules.html">Match Schedules</a></li>
                    <li><a href="news.html">News</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="logout.php">Logout</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header with Background Image -->
            <header class="header">
                <div class="header-background">
                    <div class="header-text">
                        <h1>Welcome,</h1>
                        <p><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                    </div>
                </div>
            </header>

            <!-- Highlights Section -->
            <section class="dashboard-section">
                <h2>Latest Highlights</h2>
<!-- Highlights Section -->
<!-- Highlights Section -->
<section class="dashboard-section">
    <h2>Existing Highlights</h2>

    <div class="highlight-list">
        <?php if ($highlightsQuery->num_rows > 0): ?>
            <?php while ($highlight = $highlightsQuery->fetch_assoc()): ?>
                <div class="highlight-item">
                    <img src="uploads/<?php echo htmlspecialchars($highlight['image']); ?>" alt="<?php echo htmlspecialchars($highlight['title']); ?>" class="highlight-image">
                    <h3><?php echo htmlspecialchars($highlight['title']); ?></h3>
                    <p><?php echo htmlspecialchars($highlight['description']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No highlights available. Add new highlights below.</p>
        <?php endif; ?>
    </div>
</section>
                <!-- Admin Panel for Highlights -->
                <div class="admin-panel">
                    <h3>Add New Highlight</h3>
                    <form action="actions/add_highlight_action.php" method="POST" enctype="multipart/form-data">
                        <!-- Image Upload -->
                        <label for="highlight_image">Upload Image</label>
                        <input type="file" id="highlight_image" name="highlight_image" accept="image/*"  >
                        
                        <!-- Title Input -->
                        <label for="highlight_title">Title</label>
                        <input type="text" id="highlight_title" name="highlight_title" placeholder="Enter Title" required>
                        
                        <!-- Description Input -->
                        <label for="highlight_description">Description</label>
                        <textarea id="highlight_description" name="highlight_description" placeholder="Enter Description" required></textarea>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn">Add Highlight</button>
                    </form>
                </div>


                <!-- Highlights Display Section -->
                <div class="video-grid" id="highlights-container">
                    <?php while ($highlight = $highlights->fetch_assoc()): ?>
                        <div class="video-card">
                            <div class="video-thumbnail">
                                <img src="uploads/<?php echo htmlspecialchars($highlight['image']); ?>" alt="<?php echo htmlspecialchars($highlight['title']); ?>">
                            </div>
                            <div class="video-details">
                                <h3><?php echo htmlspecialchars($highlight['title']); ?></h3>
                                <p><?php echo htmlspecialchars($highlight['description']); ?></p>
                                <a href="highlights.php" class="btn">View Highlights</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- Match Schedules Section -->
            <section class="dashboard-section">
                <h2>Upcoming Matches</h2>

                <!-- Admin Panel for Match Schedules -->
                <div class="admin-panel">
                    <h3>Add New Match</h3>
                    <div class="admin-panel">
                <h3>Add New Match</h3>
                <form action="actions/add_match_action.php" method="POST">
                    <label for="match_title">Match Title</label>
                    <input type="text" id="match_title" name="match_title" placeholder="Match Title" required>
                    
                    <label for="match_location">Location</label>
                    <input type="text" id="match_location" name="match_location" placeholder="Location" required>
                    
                    <label for="match_time">Match Time</label>
                    <input type="datetime-local" id="match_time" name="match_time" required>
                    
                    <button type="submit" class="btn">Add Match</button>
                </form>
            </div>

                </div>

                <!-- Matches Display Section -->
                <div class="card-container" id="matches-container">
                    <?php while ($match = $matches->fetch_assoc()): ?>
                        <div class="card">
                            <div class="placeholder-image">
                                <img src="uploads/<?php echo htmlspecialchars($match['image']); ?>" alt="<?php echo htmlspecialchars($match['title']); ?>">
                            </div>
                            <h3><?php echo htmlspecialchars($match['title']); ?></h3>
                            <p><?php echo htmlspecialchars($match['description']); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($match['date']); ?></p>
                            <a href="schedules.php" class="btn">View Schedule</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
