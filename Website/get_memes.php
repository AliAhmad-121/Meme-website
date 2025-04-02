<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT title, url FROM memes WHERE user_id = $user_id");

$memes = [];
while ($row = $result->fetch_assoc()) {
    $memes[] = $row;
}
echo json_encode($memes);
?>