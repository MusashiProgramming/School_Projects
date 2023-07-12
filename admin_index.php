<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="admin_index_css.css">
    <style>
      .scroll-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: red;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      transition: opacity 0.2s;
      opacity: 0;
    }

    .scroll-btn.show {
      opacity: 1;
    }
    </style>
</head>
<body>

<form method="post">
    <input class="scroll-btn" type="submit" name="home" value="Home">
</form>

<?php
    session_start(); 

    if (isset($_POST['home'])) {
        session_destroy(); 
        header('Location: index.php'); 
        exit(); 
    }
?>

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
    echo '<button id="edit-button-' . $row["manga_id"] . '" onclick="openUpdateForm(' . $row["manga_id"] . ')">Edit</button>';
    echo '<button id="delete-button-' . $row["manga_id"] . '" onclick="confirmDelete(' . $row["manga_id"] . ')">Delete</button>';
   
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
<button id="insert-form" style="position: fixed; bottom: 0; left: 50%; transform: translateX(-50%);" onclick="openInsertForm()">Insert</button>
  

  <script>
    function openUpdateForm(manga_id) {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "update_form.php");
      
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "manga_id");
    input.setAttribute("value", manga_id);
      
    form.appendChild(input);
    document.body.appendChild(form);
      
    form.submit();
  }

function confirmDelete(manga_id) {
  var result = confirm("Are you sure you want to delete this manga?");
  if (result) {
    window.location.href = "delete_manga.php?manga_id=" + manga_id;
  }
}
function openInsertForm() {
  window.location.href = "Insert_Form.php";
}

var btn = document.querySelector('.scroll-btn');


window.onscroll = function() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    btn.classList.add('show');
  } else {
    btn.classList.remove('show');
  }
};
function goHome() {
  window.location.href = "index.php";
}

</script>

</body>
</html>