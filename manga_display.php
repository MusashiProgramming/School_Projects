<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "website_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$table_name = "manga";

$sql = "SELECT * FROM $table_name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<div style='height: 75%;'><img src='images/" . $row["image_path"] . "' style='margin: 2px; width: 100%; height: 100%; object-fit: contain;'></div>";

    
    echo "<div style='margin-top: 10px;'>Name: " . $row["manga_name"]. "<br>Author name: " . $row["author_name"]. "<br>Publish date: ". $row["publish_date"]. "</div>";
    echo "<br>";
    
    echo "<div>Price: " . $row["price"] . "</div>";
  }
} else {
  echo "0 results";
}

$conn->close();
?>
