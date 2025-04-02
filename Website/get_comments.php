<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

$meme_url = $_GET['meme_url'] ?? '';
$current_user_id = $_SESSION['user_id'] ?? null;

$stmt = $conn->prepare("SELECT comments.id, comments.comment, comments.created_at, comments.user_id, users.username
                        FROM comments
                        JOIN users ON comments.user_id = users.id
                        WHERE comments.meme_url = ?
                        ORDER BY comments.created_at DESC");
$stmt->bind_param("s", $meme_url);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = [
        "id" => $row['id'],
        "comment" => $row['comment'],
        "created_at" => $row['created_at'],
        "username" => $row['username'],
        "user_id" => $row['user_id']
    ];
}

echo json_encode([
    "comments" => $comments,
    "current_user_id" => $current_user_id
]);
?>
