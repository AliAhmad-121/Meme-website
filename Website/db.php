<?php
// Database connection
$servername = "localhost";
$username = "meme";
$password = "BaraaandAli";
$dbname = "meme_site";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>