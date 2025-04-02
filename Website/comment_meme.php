<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$meme_url = $_POST['meme_url'];
$comment = $_POST['comment'];

$stmt = $conn->prepare("INSERT INTO comments (user_id, meme_url, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $meme_url, $comment);

echo $stmt->execute() ?
    json_encode(["success" => true]) :
    json_encode(["success" => false, "error" => $stmt->error]);
?>
