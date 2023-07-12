<!DOCTYPE html>
<html>
<head>
	<title>Manga Shop</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="index_css.css">
</head>
<body>
<header>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="manga_gallery.php">Browse</a></li>
			<li><a href="contact.php">Contact</a></li>
			<?php
			session_start();
			if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
				echo '<li><a href="profile_dashboard.php">Profile</a></li>';
			} else {
				echo '<li><a href="login.php">Profile</a></li>';
			}
			?>
		</ul>
	</nav>
</header>
<main>
	<section id="introduction">
        <br><br><br>
		<h2>Discover the World of Manga</h2>
		<p>Welcome to Manga Shop, your one-stop-shop for all things manga! With a huge selection of the latest titles and classic favorites, we have everything you need to immerse yourself in the exciting world of Japanese comics.</p>
		<p>Whether you're a longtime fan or just discovering manga for the first time, our friendly staff is here to help you find the perfect titles to suit your interests. From action-packed shonen manga to heartwarming shojo stories, we have something for everyone.</p>
	</section>

	<h2 style="text-align: center;">Most Popular Mangas!</h2>
	<section id="featured_slideshow" style="display: flex; align-items: center;">
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
    $limit = 8;

    $sql = "SELECT * FROM $table_name LIMIT $limit";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            if ($counter % 8 == 0) {
                echo '<div class="card-container">';
            }

            echo '<div class="card">';
            echo '<div class="card-header"></div>';
            echo '<div class="card-content" style="height: 100%;">';
            echo '<div style="height: 75%;"><img src="images/' . $row["image_path"] . '" style="margin: 2px; width: 100%; height: 100%; object-fit: contain;"></div>';
            echo '<div style="margin-top: 10px;">Name: ' . $row["manga_name"] . '<br>Author name: ' . $row["author_name"] . '<br>Publish date: ' . $row["publish_date"] . '<br>Price: $' . $row["price"] . '</div>';
            echo '</div>';

            echo '</div>';

            if ($counter % 8 == 7) {
                echo '</div>';
            }

            $counter++;
        }

        if ($counter % 8 != 0) {
            echo '</div>';
        }
    } else {
        echo "0 results";
    }

    $conn->close();
?>
</section>
</main>
	

    <footer>
		<p>&copy; 2023 Manga Shop</p>
	</footer>
</body>
</html>


