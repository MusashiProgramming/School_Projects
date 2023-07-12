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

$user_id = $_POST['user_id'];
$manga_id = $_POST['manga_id'];

$sql = "INSERT INTO user_manga_collection (user_id, manga_id) VALUES ('$user_id', '$manga_id')";

if ($conn->query($sql) === TRUE) {
  echo "Manga added to collection successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
