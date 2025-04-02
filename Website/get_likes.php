<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

// Validate input
if (!isset($_GET['meme_url']) || empty($_GET['meme_url'])) {
    echo json_encode(["likes" => 0, "error" => "Missing meme_url"]);
    exit;
}

$meme_url = $_GET['meme_url'];

// Query the number of likes for the meme
$stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE meme_url = ?");
$stmt->bind_param("s", $meme_url);
$stmt->execute();
$stmt->bind_result($likeCount);
$stmt->fetch();
$stmt->close();

// Output JSON result
echo json_encode(["likes" => $likeCount]);
?>
