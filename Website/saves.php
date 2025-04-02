<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: loginpage.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Memes</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="likes_comments.css">
    <link rel="stylesheet" href="saves.css">
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
        <a href="feed.php"><i class="fas fa-rss"></i> Feed</a>
        <a href="saves.php" class="active"><i class="fas fa-bookmark"></i> Saved</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="info.php"><i class="fas fa-info-circle"></i> About</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

<div id="overlay" onclick="toggleSidebar()"></div>

    <div class="container">
        <h1>Your Saved Memes</h1>
        <div id="savedMemesContainer" class="meme-container"></div>
    </div>

    <script src="saves.js"></script>
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
