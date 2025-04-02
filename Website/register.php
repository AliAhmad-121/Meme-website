<?php
include 'db.php';
$error = null;
$success = false;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        try {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed);
            $stmt->execute();

            $success = true;
            header("Location: loginpage.php");
            exit;

        } catch (mysqli_sql_exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $error = "❌ There is already an account with the same username.";
            } else {
                $error = "❌ Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
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
            <h2>Register</h2>
            <?php if ($error): ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <a href="loginpage.php">Already have an account?</a>
                <button type="submit" class="btn">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="text">Register</span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
