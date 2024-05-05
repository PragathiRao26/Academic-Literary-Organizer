<?php
session_start();
if ($_SESSION['loggedin'] & $_SESSION['type'] != 'admin') {
    header("Location: index.php"); 
    exit();
}
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['type'] != 'admin') {
      header("Location: login.php"); 
      exit();
}
require 'connection.php';

if (isset($_POST['submit'])) {
    $bookName = $_POST['bookName'];
    
    // Use prepared statements to prevent SQL injection
    $deleteQuery = "DELETE FROM `bookinfo` WHERE bname = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, 's', $bookName);
    
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>alert("Book with the name ' . $bookName . ' has been deleted.");</script>';
    } else {
        echo '<script>alert("Error deleting book.");</script>';
    }
}

// Retrieve a list of books
$query = "SELECT DISTINCT bname FROM bookinfo";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Delete Books</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Additional CSS for the Delete Page */
        .delete-container {
            text-align: center;
            margin: 20px auto;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .delete-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .book-list {
            text-align: left;
        }

        .delete-button {
            background-color: #AE0000;
            color: #000;
            padding: 10px 20px;
            border: 2px solid black;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.3s;
        }

        .delete-button:hover {
            background-color: #fff;
            color: #AE0000;
            border-color: #AE0000;
            transform: scale(1.05);
        }
    </style>
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
    <br>
    <br>
    <main>
        <div class="delete-container">
            <h2>Delete Books</h2>
            <form method="post" action="delete.php">
                <div class="book-list">
                    <label for="bookName">Select a book to delete:</label>
                    <select name="bookName" id="bookName">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['bname'] . '">' . $row['bname'] . '</option>';
                            }
                        } else {
                            echo '<option value="" disabled>No books found</option>';
                        }
                        ?>
                    </select>
                </div>
                <br>
                <button class="delete-button" type="submit" name="submit">Delete Selected Book</button>
            </form>
        </div>
    </main>
</body>
</html>
