<?php
    // Connect to the database
    $servername = "127.0.0.1";
    $username = "root";
    $password = "root";
    $dbname = "website_database";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $manga_id = $_POST['manga_id'];

    if (isset($_POST['submit'])) {
        $manga_name = $_POST['manga_name'];
        $author_name = $_POST['author_name'];
        $publish_date = $_POST['publish_date'];
        $image_path = $_FILES['image_path']['name'];
        $temp_image_path = $_FILES['image_path']['tmp_name'];
        $price = $_POST['price'];

        if ($image_path != '') {
            $upload_path = 'uploads/';
            $upload_file = $upload_path . basename($image_path);
            move_uploaded_file($temp_image_path, $upload_file);
        } else {
            $stmt = mysqli_prepare($conn, "SELECT image_path FROM manga WHERE manga_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $manga_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $image_path = $row['image_path'];
            } else {
                die('Manga not found');
            }
            mysqli_stmt_close($stmt);
        }

        $stmt = mysqli_prepare($conn, "UPDATE manga SET manga_name=?, author_name=?, publish_date=?, image_path=?, price=? WHERE manga_id=?");
        mysqli_stmt_bind_param($stmt, "ssssdi", $manga_name, $author_name, $publish_date, $image_path, $price, $manga_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: admin_index.php");
        exit();
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM manga WHERE manga_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $manga_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $manga = mysqli_fetch_assoc($result);
    if (!$manga) {
        die('Manga not found');
    }
    mysqli_stmt_close($stmt);
?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Update Book Information</title>
    <style>
form {
  max-width: 500px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-family: Arial, sans-serif;
}

h1 {
  font-size: 24px;
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

input[type="text"],
input[type="date"],
input[type="file"] {
  width: 90%;
  padding: 10px;
  margin-bottom: 20px;
  border: none;
  border-radius: 5px;
  background-color: #fff;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

input[type="submit"] {
  display: block;
  margin: 0 auto;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #4CAF50;
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
  background-color: #3e8e41;
}

    </style>
  </head>

  <body>
      <form action="#" method="post" enctype="multipart/form-data">
        <h1 style="text-align: center">Update Manga Information</h1>
        <input type="hidden" name="manga_id" value="<?php echo $manga['manga_id']; ?>">
        <label for="manga_name">Manga Name:</label>
        <input type="text" id="manga_name" name="manga_name" value="<?php echo $manga['manga_name']; ?>" required>
        <label for="author_name">Author Name:</label>
        <input type="text" id="author_name" name="author_name" value="<?php echo $manga['author_name']; ?>" required>
        <label for="publish_date">Publication Date:</label>
        <input type="date" id="publish_date" name="publish_date" value="<?php echo $manga['publish_date']; ?>" required>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo $manga['price']; ?>" min="0" required>
        <hr>
        <label for="image_path"></label>
        <?php if ($manga['image_path']): ?>
          <img style="width: 225px; height: 300px; margin-left: 35%" src="images/<?php echo $manga['image_path']; ?>" alt="Manga Cover">
        <?php endif; ?>
        <input type="file" id="image_path" name="image_path" accept="image/*">
        <input type="submit" name="submit" value="Update">
      </form>
  </body>
</html>