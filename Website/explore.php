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
    <title>Explore Memes</title>
    <link rel="stylesheet" href="explore.css">
    <link rel="stylesheet" href="likes_comments.css">
    <link rel="stylesheet" href="enhanced_comments.css">
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
        <a href="explore.php"class="active"><i class="fas fa-search"></i> Explore</a>
        <a href="feed.php"><i class="fas fa-rss"></i> Feed</a>
        <a href="saves.php"><i class="fas fa-bookmark"></i> Saved</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="info.php"><i class="fas fa-info-circle"></i> About</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

    <div id="overlay" onclick="toggleSidebar()"></div>

    <div class="container" id="memeContainer">
        <!-- Memes will be loaded here -->
    </div>

    <div class="loader loader--style8" id="loader" style="display: none;">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
            width="24px" height="30px" viewBox="0 0 24 30">
            <rect x="0" y="10" width="4" height="10" fill="#333" opacity="0.2">
                <animate attributeName="opacity" values="0.2; 1; .2" begin="0s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="height" values="10; 20; 10" begin="0s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="y" values="10; 5; 10" begin="0s" dur="0.6s" repeatCount="indefinite" />
            </rect>
            <rect x="8" y="10" width="4" height="10" fill="#333" opacity="0.2">
                <animate attributeName="opacity" values="0.2; 1; .2" begin="0.15s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="height" values="10; 20; 10" begin="0.15s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="y" values="10; 5; 10" begin="0.15s" dur="0.6s" repeatCount="indefinite" />
            </rect>
            <rect x="16" y="10" width="4" height="10" fill="#333" opacity="0.2">
                <animate attributeName="opacity" values="0.2; 1; .2" begin="0.3s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="height" values="10; 20; 10" begin="0.3s" dur="0.6s" repeatCount="indefinite" />
                <animate attributeName="y" values="10; 5; 10" begin="0.3s" dur="0.6s" repeatCount="indefinite" />
            </rect>
        </svg>
    </div>

    <script src="explores.js"></script>
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