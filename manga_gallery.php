<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="admin_index_css.css">

    <script>
        function confirmOrder(mangaId) {
            if (confirm("Are you sure you want to order this manga?")) {
                // Send an AJAX request to insert the data into the database
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("Order placed successfully.");
                    }
                };
                xmlhttp.open("POST", "insert_order.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("manga_id=" + mangaId);
            }
        }
    </script>

</head>
<body>

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

  $table_name = "manga";

  $sql = "SELECT * FROM $table_name";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $counter = 0;
    while($row = $result->fetch_assoc()) {
      if ($counter % 4 == 0) {
        echo '<div class="card-container">';
      }

      echo '<div class="card">';
      echo '<div class="card-header"></div>';
      echo '<div class="card-content">';
      echo '<div style="height: 75%;"><img src="images/' . $row["image_path"] . '" style="margin: 2px; width: 100%; height: 100%; object-fit: contain;"></div>';
      
      echo '<div style="margin-top: 10px;">Name: ' . $row["manga_name"] . '<br>Author name: ' . $row["author_name"] . '<br>Publish date: ' . $row["publish_date"] . '<br>Price: $' . $row["price"] . '</div>';
      echo '</div><br>';
      echo '<button class="order-button" onclick="confirmOrder(' . $row["manga_id"] . ')">Order</button>'; 
      echo '</div>';

      if ($counter % 4 == 3) {
        echo '</div>';
      }

      $counter++;
    }

    if ($counter % 4 != 0) {
      echo '</div>';
    }
  } else {
    echo "0 results";
  }

  $conn->close();
?>

</body>
</html>
