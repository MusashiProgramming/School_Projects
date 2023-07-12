<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "website_database";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die("Access denied.");
}


if (!isset($_POST["manga_id"])) {
    die("Invalid request.");
}


$mangaId = $_POST["manga_id"];
$userId = $_SESSION["user_id"];


$stmt = $conn->prepare("DELETE FROM user_manga_collection WHERE manga_id = ? AND user_id = ?");
$stmt->bind_param("ii", $mangaId, $userId);
$stmt->execute();


$stmt->close();
$conn->close();
echo "Manga deleted successfully.";
?>

