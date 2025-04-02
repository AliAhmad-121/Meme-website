
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: loginpage.php');
    exit;
}
include 'db.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $profile_picture);
$stmt->fetch();
$stmt->close();
$updated = isset($_GET['updated']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="alert.css">

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
        <a href="saves.php"><i class="fas fa-bookmark"></i> Saved</a>
        <a href="profile.php" class="active"><i class="fas fa-user"></i> Profile</a>
        <a href="info.php"><i class="fas fa-info-circle"></i> About</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

<div id="overlay" onclick="toggleSidebar()"></div>

    <div class="container profile-container">
        <h1 class="page-title">Welcome, <?php echo htmlspecialchars($username); ?></h1>

        <?php if ($updated): ?>
        <div class="success-message">✅ Profile updated successfully!</div>
        <?php endif; ?>

        <div class="profile-content">
            <div class="profile-info">
                <img src="<?php echo $profile_picture ? $profile_picture : 'default-avatar.png'; ?>" alt="Profile Picture" class="profile-picture">
                <form action="update_profile.php" method="POST" class="profile-form">
                    <input type="text" name="new_username" placeholder="New Username">
                    <input type="password" name="new_password" placeholder="New Password">
                    <input type="text" name="profile_picture" placeholder="Profile Picture URL">
                    <button type="submit" class="btn">Update Profile</button>
                    <button type="button" id="delete-account" class="btn delete-btn">Delete Account</button>
                </form>
            </div>

            <div class="upload-form">
                <h2>Upload a Meme</h2>
                <form action="upload_meme.php" method="POST">
                    <input type="text" name="title" placeholder="Meme Title" required>
                    <input type="text" name="meme_url" placeholder="Meme Image URL" required>
                    <button type="submit" class="btn">Upload Meme</button>
                </form>
            </div>
        </div>
    </div>
    <script src="profile.js"></script>
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