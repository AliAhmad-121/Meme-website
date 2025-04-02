<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$id = $_POST['id'];
$comment = $_POST['comment'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE comments SET comment = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("sii", $comment, $id, $user_id);

echo $stmt->execute() ? json_encode(["success" => true]) : json_encode(["success" => false]);
?>
