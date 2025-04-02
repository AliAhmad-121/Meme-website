<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit;
}

$title = $_POST['title'];
$url = $_POST['url'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO memes (user_id, title, url) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $title, $url);
echo $stmt->execute() ? json_encode(["success" => true]) : json_encode(["success" => false, "error" => $stmt->error]);
?>