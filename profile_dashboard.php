<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "website_database";
$user_id = $_SESSION['user_id']; 


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$user_query = "SELECT * FROM users WHERE users_id = $user_id";
        $user_result = $conn->query($user_query);
        if ($user_result->num_rows > 0) {
            $user_row = $user_result->fetch_assoc();
            echo '<div class="user-card">';
            echo '<div class="user-info">';
            echo '<p>User Information:</p>';
            echo '<p>Username: ' . $user_row["username"] . '</p>';
            echo '<p>Email: ' . $user_row["email"] . '</p>';
            echo '</div>'; 

            echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
            echo '<input type="submit" name="logout" value="Log out">';
            echo '<input type="button" name="logout" value="Home" onclick="window.location=\'index.php\'">';
            echo '</form>';

            echo '</div>'; 
        }



$manga_query = "SELECT * FROM user_manga_collection JOIN manga ON user_manga_collection.manga_id = manga.manga_id WHERE user_id = $user_id";
$manga_result = $conn->query($manga_query);
if ($manga_result->num_rows > 0) {
    echo '<div class="card-container">';
    while ($manga_row = $manga_result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<div class="card-header"><button class="card-button" data-manga-id="' . $manga_row["manga_id"] . '">Remove order</button></div>';
        echo '<div class="card-content">';
        echo 'Manga Name: ' . $manga_row["manga_name"];
        echo "<p>Author Name: " . $manga_row["author_name"] . "</p>";
        echo "<p>Publish Date: " . $manga_row["publish_date"] . "</p>";
        echo "<p>Price: $" . $manga_row["price"] . "</p>";
        echo '<div style="height: 75%;"><img src="images/' . $manga_row["image_path"] . '" style="margin: 2px; width: 100%; height: 100%; object-fit: contain;"></div>';
        echo "<br><br>";
        echo '</div>'; 
        echo '</div>'; 
    }
    echo '</div>'; 
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Profile Dashboard</title>
    <link rel="stylesheet" href="profile_dashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
    $(document).ready(function() {
        $(".card-button").click(function() {
            var mangaId = $(this).data("manga-id");
            $.ajax({
                type: "POST",
                url: "delete_manga_profile.php",
                data: { manga_id: mangaId },
                success: function(response) {
                    alert(response);
                    location.reload(); 
                }
            });
        });
    });
</script>

</head>
<body>
    <?php 
        if(isset($_POST['logout'])) { 
            session_destroy(); 
            header("Location: index.php"); 
        }
    ?>


</body>
</html>
