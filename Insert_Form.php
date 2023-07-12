<!DOCTYPE html>
<html>
<head>
	<title>Add New Manga</title>
	<style>
		form {
			display: flex;
			flex-direction: column;
			max-width: 500px;
			margin: 0 auto;
			padding: 20px;
			background-color: #f9f9f9;
			border-radius: 10px;
			box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
		}

		label {
			font-size: 18px;
			margin-bottom: 10px;
			color: #333;
		}

		input {
			font-size: 16px;
			padding: 10px;
			border-radius: 5px;
			border: none;
			margin-bottom: 20px;
			background-color: #fff;
			box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
			color: #333;
		}

		button {
			font-size: 18px;
			background-color: #4CAF50;
			color: white;
			border: none;
			padding: 10px;
			border-radius: 5px;
			cursor: pointer;
		}

		button:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>

<form method="POST" enctype="multipart/form-data">
	<label for="name">Name of Manga:</label>
	<input type="text" id="name" name="name">

	<label for="author">Author Name:</label>
	<input type="text" id="author" name="author">

	<label for="date">Upload Date:</label>
	<input type="date" id="date" name="date" min="1950-01-01" max="<?php echo date('Y-m-d'); ?>" required>

	<label for="price">Price:</label>
	<input type="number" id="price" name="price" min="0" required>

	<label for="image">Image:</label>
	<input type="file" id="image" name="image">

	<button type="submit" name="submit">Submit</button>
</form>

<?php
if(isset($_POST['submit'])) {
	$name = $_POST['name'];
	$author = $_POST['author'];
	$date = date('Y-m-d', strtotime($_POST['date']));
	$price = $_POST['price'];
	$image = $_FILES['image']['name'];

	$servername = "127.0.0.1";
	$username = "root";
	$password = "root";
	$dbname = "website_database";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT MAX(manga_id) as max_id FROM manga";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$new_id = $row["max_id"] + 1;
	} else {
		$new_id = 1;
	}

	$sql = "INSERT INTO manga (manga_id, manga_name, author_name, publish_date, price, image_path) VALUES ('$new_id', '$name', '$author', '$date', '$price', '$image')";
	if ($conn->query($sql) === TRUE) {
		echo "<p>New manga added successfully</p>";
		header("Location: admin_index.php");
		exit();
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}
?>

</body>
</html>