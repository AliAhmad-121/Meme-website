<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$new_username = $_POST['username'];
$new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
$stmt->bind_param("ssi", $new_username, $new_password, $user_id);
echo $stmt->execute() ? json_encode(["success" => true]) : json_encode(["success" => false, "error" => $stmt->error]);
?>