<?php
// Include database connection
include 'db.php';
session_start();

$error = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            header('Location: explore.php');
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Lacquer&display=swap" rel="stylesheet">
    <link rel="icon" href="../Data/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="snowflakes">
        <div class="snowflake"><p><b>😂</b></p></div>
        <div class="snowflake"><p><b>🤣</b></p></div>
        <div class="snowflake"><p><b>😁</b></p></div>
        <div class="snowflake"><p><b>😆</b></p></div>
        <div class="snowflake"><p><b>😂</b></p></div>
        <div class="snowflake"><p><b>🤣</b></p></div>
        <div class="snowflake"><p><b>😁</b></p></div>
        <div class="snowflake"><p><b>😆</b></p></div>
        <div class="snowflake"><p><b>😂</b></p></div>
        <div class="snowflake"><p><b>🤣</b></p></div>
    </div>
    
    <div class="container">
        <div class="logo-container">
            <img src="../Data/logo_memes.png" alt="Logo" class="logo">
        </div>
        
        <div class="login-container">
            <h2>Log In</h2>
            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form id="loginForm" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="register.php">Don't have an account?</a>
                <button type="submit" class="btn">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="text">Login</span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>