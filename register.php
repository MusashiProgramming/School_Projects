<!DOCTYPE html>
<html>
<head>
	<title>User Registration Form</title>
    <style>

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

body {
	font-family: Arial, sans-serif;
	font-size: 16px;
	line-height: 1.5;
	color: #333;
	background-color: #fff;
}

h2 {
	margin-bottom: 20px;
	text-align: center;
}

form {
	max-width: 600px;
	margin: 0 auto;
	padding: 20px;
	border: 1px solid #ccc;
	border-radius: 5px;
}

label {
	display: block;
	margin-bottom: 10px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
	padding: 10px;
	border: 1px solid #ccc;
	border-radius: 5px;
	width: 100%;
	margin-bottom: 20px;
}

input[type="submit"] {
	background-color: #4CAF50;
	color: #fff;
	border: none;
	padding: 10px 20px;
	border-radius: 5px;
	cursor: pointer;
}

input[type="submit"]:hover {
	background-color: #3e8e41;
}
    </style>
</head>
<body>
	<h2>User Registration Form</h2>
	<form method="post" action="">
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required><br><br>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required><br><br>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required><br><br>

		<input type="submit" name="submit" value="Register">
	</form>

	<?php
            $host = "127.0.0.1";
            $username = "root"; 
            $password = "root"; 
            $database = "website_database"; 
            $conn = mysqli_connect($host, $username, $password, $database);

            if (isset($_POST["submit"])) {
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];

                $last_id_query = "SELECT MAX(users_id) AS max_id FROM users";
                $last_id_result = mysqli_query($conn, $last_id_query);
                $last_id_row = mysqli_fetch_assoc($last_id_result);
                $last_id = $last_id_row["max_id"];

                $next_id = $last_id + 1;

                $query = "INSERT INTO users (users_id, username, email, password) VALUES ('$next_id', '$username', '$email', '$password')";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                
                mysqli_close($conn);
            }


	?>
</body>
</html>