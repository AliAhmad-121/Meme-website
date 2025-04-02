<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT meme_url FROM saved_memes WHERE user_id = $user_id");

$saved = [];
while ($row = $result->fetch_assoc()) {
    $saved[] = $row['meme_url'];
}
echo json_encode($saved);
?>
