<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        header("Location: signup.php"); 
        exit();
    }
    if($_POST['work']=='search')
    {
        $stext=$_POST['stext'];
    }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <nav class="navbar">
            <div class="navbar-logo">
            <div class="logo_text">
                <div style="font-family: 'argue_demo'; font-size: 32px; color:white;">Academic Literary Organizer</div>
            </div>
            </div>
            <div class="navbar-menu">
                <ul>
                    <li><a href="books.php">Home</a></li>
                    <li><a href="advsearch.php">Advanced Search&nbsp;</a></li>
                    <li><a href="upload.php">Upload New</a></li>
                    <?php if ($_SESSION['type'] == 'admin'): ?>
                    <li><a href="delete.php">&nbsp;Admin Delete</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>

        <div class="book-gallery">
            <br><br>
        <?php
        // Establish a database connection
        include 'connection.php';
        // Retrieve book information from the database
        $sql = "SELECT *FROM bookinfo WHERE bname='$stext'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Calculate the rating
                $rating = $row['totalrating'] / $row['rno'];
                // Generate the HTML for each book card
                echo '<div class="book-card">';
                ?>
                <img src="img/<?php echo $row["image"]; ?>.jpg"
                <?php
                echo '<h3>' . $row['bname'] . '</h3>';
                echo '<p>Author: ' . $row['author'] . '</p>';
                echo '<p>Ratings: ' . $rating . '</p>';
                echo '<br>';
                echo '<p><a href="login.html">Click to download</a></p>';
                echo '<br>';
                echo '<div class="rating">';
                echo '<form action="rate_book.php" method="post">';
                echo '<input type="hidden" name="book_name" value="' . $row['bname'] . '"?>';
                echo '<input type="number" name="rating" min="1" max="5" required>';
                echo '<button type="submit">Rate</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No books found in the database.";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
    </main>
</body>
</html>