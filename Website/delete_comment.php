<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$id = $_POST['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);

echo $stmt->execute() ? json_encode(["success" => true]) : json_encode(["success" => false]);
?>
