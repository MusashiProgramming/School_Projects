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


if (!isset($_SESSION['user_id'])) {
    echo "Please log in first.";
    exit;
}


$manga_id = $_POST['manga_id'];


$user_id = $_SESSION['user_id'];
$sql = "INSERT INTO user_manga_collection (user_id, manga_id) VALUES ($user_id, $manga_id)";
if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
