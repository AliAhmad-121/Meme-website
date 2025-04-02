<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="info.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lacquer&display=swap" rel="stylesheet">
    <link rel="icon" href="../Data/favicon.ico" type="image/x-icon">
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
        <a href="saves.php"><i class="fas fa-bookmark"></i> Saved</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="info.php" class="active"><i class="fas fa-info-circle"></i> About</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

    <div id="overlay" onclick="toggleSidebar()"></div>

    <div class="container">
        <img src="../Data/logo_memes_nocolor _white.png" alt="Logo" class="logo-text">
        <h1>About Meme Website</h1>
        <p>Welcome to the Meme Website! This platform allows users to explore, save, like, comment, and manage memes. Whether you're looking for a laugh or want to save your favorite memes for later, this website has you covered.</p>

        <h2>Features</h2>
        <ul>
            <li><strong>Explore Memes:</strong> Browse through a collection of memes fetched from external sources and discover new ones.</li>
            <li><strong>Save Memes:</strong> Save your favorite memes with a single click and access them anytime.</li>
            <li><strong>Unsave Memes:</strong> Remove memes from your saved collection when you no longer need them.</li>
            <li><strong>Like Memes:</strong> Show appreciation for memes by liking them.</li>
            <li><strong>Comment on Memes:</strong> Add comments to memes and engage with the community.</li>
            <li><strong>Profile Page:</strong> Manage your profile, update your username or password, and view all your uploaded memes.</li>
            <li><strong>Upload Memes:</strong> Share your own memes with the community.</li>
            <li><strong>Responsive Design:</strong> Enjoy a seamless experience across devices with a fully responsive design.</li>
        </ul>

        <h2>Technologies Used</h2>
        <p>This project is built using the following technologies:</p>
        <ul>
            <li><strong>HTML5:</strong> For structuring the website and its content.</li>
            <li><strong>CSS3:</strong> For styling, animations, and responsive design.</li>
            <li><strong>JavaScript:</strong> For interactivity, dynamic content, and functionality.</li>
            <li><strong>PHP:</strong> For server-side logic and database interactions.</li>
            <li><strong>MySQL:</strong> For storing user data, memes, likes, and comments.</li>
        </ul>

        <h2>Pages Overview</h2>
        <ul>
            <li><strong>Explore Page:</strong> Displays a collection of memes fetched from external sources. Each meme includes "Save," "Like," and "Comment" buttons for interaction.</li>
            <li><strong>Saves Page:</strong> Shows all the memes you have saved. Includes an "Unsave" button to remove memes from your collection.</li>
            <li><strong>Feed Page:</strong> Displays memes uploaded by users in the community. Includes "Like," "Save," and "Comment" buttons for interaction.</li>
            <li><strong>Profile Page:</strong> Displays user information, allows updates to username or password, and provides a form to upload new memes.</li>
            <li><strong>Login Page:</strong> Allows users to log in with their credentials.</li>
            <li><strong>Register Page:</strong> Allows new users to create an account with input validation.</li>
            <li><strong>Logout:</strong> Logs the user out and redirects to the Login page.</li>
        </ul>

        <h2>Creators</h2>
        <p>This website was created by:</p>
        <ul>
            <li><strong>Baraa Alshugri</strong> (B2205.090047)</li>
            <li><strong>Ali Salamah</strong> (B2208.9393)</li>
        </ul>
        <p>Year: <strong>2024-2025</strong></p>
    </div>

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