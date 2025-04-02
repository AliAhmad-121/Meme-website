
<?php
session_start();
include 'db.php';
header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

// Optional: delete user's content
$conn->query("DELETE FROM comments WHERE user_id = $user_id");
$conn->query("DELETE FROM likes WHERE user_id = $user_id");
$conn->query("DELETE FROM saved_memes WHERE user_id = $user_id");
$conn->query("DELETE FROM memes WHERE user_id = $user_id");

// Delete user
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
if ($stmt->execute()) {
    session_destroy();
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to delete user"]);
}
?>