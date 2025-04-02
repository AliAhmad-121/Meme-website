<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: loginpage.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$url = $_POST['meme_url'];

$stmt = $conn->prepare("INSERT INTO memes (user_id, title, url) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $title, $url);
$stmt->execute();

header("Location: feed.php");
?>
