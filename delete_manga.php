<?php

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "website_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['manga_id'])) {
  $manga_id = $_GET['manga_id'];

  $sql = "DELETE FROM genre_manga_table WHERE manga_id = $manga_id";
  if ($conn->query($sql) === TRUE) {
    echo "Related records deleted successfully.<br>";
  } else {
    echo "Error deleting related records: " . $conn->error;
  }

  $sql = "DELETE FROM manga WHERE manga_id = $manga_id";
  if ($conn->query($sql) === TRUE) {
    echo "Manga deleted successfully.<br>";

    $sql = "UPDATE manga SET manga_id = manga_id - 1 WHERE manga_id > $manga_id";
    if ($conn->query($sql) === TRUE) {
      echo "Manga IDs updated successfully.";
    } else {
      echo "Error updating manga IDs: " . $conn->error;
    }
  } else {
    echo "Error deleting manga: " . $conn->error;
  }
}

$conn->close();

header("Location: admin_index.php");
exit();

?>