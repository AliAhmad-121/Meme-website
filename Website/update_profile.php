<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: loginpage.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$new_username = trim($_POST['new_username']);
$new_password = trim($_POST['new_password']);
$profile_picture = trim($_POST['profile_picture']);

$fields = [];
$params = [];
$types = "";

if (!empty($new_username)) {
    $fields[] = "username = ?";
    $params[] = $new_username;
    $types .= "s";
}
if (!empty($new_password)) {
    $fields[] = "password = ?";
    $params[] = password_hash($new_password, PASSWORD_DEFAULT);
    $types .= "s";
}
if (!empty($profile_picture)) {
    $fields[] = "profile_picture = ?";
    $params[] = $profile_picture;
    $types .= "s";
}

if (count($fields) > 0) {
    $query = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
    $params[] = $user_id;
    $types .= "i";

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->close();
    header("Location: profile.php?updated=1");
    exit;
} else {
    header("Location: profile.php");
    exit;
}
?>
