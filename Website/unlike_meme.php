<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

if (!isset($_POST['meme_url']) || empty($_POST['meme_url'])) {
    echo json_encode(["success" => false, "error" => "Missing meme URL"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$meme_url = $_POST['meme_url'];

// Delete the like
$stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND meme_url = ?");
$stmt->bind_param("is", $user_id, $meme_url);
$stmt->execute();
$stmt->close();

// Get updated like count
$stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE meme_url = ?");
$stmt->bind_param("s", $meme_url);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

echo json_encode(["success" => true, "likes" => $count]);
?>
