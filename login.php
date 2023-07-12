<?php
session_start(); // Initialize the session

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "website_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["loggedin"] = true; // Set session variable to true
        $_SESSION["user_id"] = $row["users_id"]; // Store the user's ID in session variable
        if ($username == "admin" && $password == "admin") {
            header("Location: admin_index.php");
        } else {
			header("Location: profile_dashboard.php?user_id=" . $_SESSION["users_id"]);
        }
        exit();
    } else {
        echo "Invalid username or password";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            max-width: 500px;
            margin: 50px auto;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-bottom: 10px;
            width: 95%;
            background-color: gainsboro;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        input:focus {
            outline: 2px solid #00BFFF;
        }
        button.register-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 0 auto;
        }

        button.register-btn:hover {
            background-color: #3e8e41;
        }

    </style>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required>

		<input type="submit" value="Login">
	</form>

<div style="text-align: center;">
    <p>Don't have an account? <button class="register-btn" onclick="window.location.href='register.php'">Register</button></p>
</div>
</body>
</html>
