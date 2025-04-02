<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: loginpage.php');
    exit;
}
include 'db.php';

$result = $conn->query("SELECT memes.id, memes.title, memes.url, memes.uploaded_at, users.username, users.profile_picture 
                        FROM memes 
                        JOIN users ON memes.user_id = users.id 
                        ORDER BY memes.uploaded_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Feed</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="feed.css">
    <link href="https://fonts.googleapis.com/css2?family=Lacquer&display=swap" rel="stylesheet">
    <link rel="icon" href="../Data/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="app-bar">
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button> <!-- Hamburger menu -->
    <div class="logo-container">
        <img class="logo" src="../Data/logo_memes_nocolor.png" alt="Logo">
    </div>
</div>

<nav id="sidebar-nav" class="sidebar">
        <a href="explore.php"><i class="fas fa-search"></i> Explore</a>
        <a href="feed.php" class="active"><i class="fas fa-rss"></i> Feed</a>
        <a href="saves.php"><i class="fas fa-bookmark"></i> Saved</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="info.php"><i class="fas fa-info-circle"></i> About</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

<div id="overlay" onclick="toggleSidebar()"></div>

    <div class="container">
        <h1 class="page-title">Community Feed</h1>
        <div id="feedContainer" class="meme-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="meme" data-url="<?php echo $row['url']; ?>">
                    <div class="meme-header">
                        <img src="<?php echo $row['profile_picture'] ?: 'default-avatar.png'; ?>" alt="avatar" class="avatar">
                        <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                    </div>
                    <img src="<?php echo htmlspecialchars($row['url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="meme-image">
                    <h3 class="meme-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                    <div class="buttons">
                        <button class="like-btn" data-url="<?php echo $row['url']; ?>">❤️ 0</button>
                        <button class="save-btn" data-url="<?php echo $row['url']; ?>"><i class="fas fa-save"></i> Save</button>
                    </div>
                    <div class="comments-container">
                        <div class="comment-input-box">
                            <input class="comment-input" placeholder="Add a comment..." data-url="<?php echo $row['url']; ?>">
                            <button class="add-comment-btn">Add</button>
                        </div>
                        <div class="comment-list"></div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="feed.js"></script>
    <script src="feed_like_toggle.js"></script>
    <script>
function toggleSidebar() {
  const nav = document.getElementById('sidebar-nav');
  const overlay = document.getElementById('overlay');
  nav.classList.toggle('open');
  overlay.classList.toggle('show');
}
</script>
</body>
</html>
