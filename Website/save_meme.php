<?php
include 'db.php';
session_start();
header('Content-Type: application/json');

// Debug mode (set to true for development, false for production)
define('DEBUG', true);

if (DEBUG) {
    error_log("SESSION: " . print_r($_SESSION, true));
    error_log("POST: " . print_r($_POST, true));
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$meme_url = filter_var($_POST['meme_url'] ?? null, FILTER_SANITIZE_URL);

// Validate meme_url
if (!$meme_url) {
    echo json_encode(["success" => false, "error" => "Missing meme_url"]);
    exit;
}

if (!filter_var($meme_url, FILTER_VALIDATE_URL)) {
    echo json_encode(["success" => false, "error" => "Invalid URL format"]);
    exit;
}

// Check for duplicate meme URLs
$checkStmt = $conn->prepare("SELECT id FROM saved_memes WHERE user_id = ? AND meme_url = ?");
$checkStmt->bind_param("is", $user_id, $meme_url);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo json_encode(["success" => false, "error" => "Meme already saved"]);
    exit;
}

// Insert the meme into the database
$stmt = $conn->prepare("INSERT INTO saved_memes (user_id, meme_url) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $meme_url);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    if (DEBUG) {
        error_log("SQL Error: " . $stmt->error);
    }
    echo json_encode(["success" => false, "error" => "Failed to save meme"]);
}
?>
