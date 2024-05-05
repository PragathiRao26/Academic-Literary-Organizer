<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        header("Location: signup.php"); 
        exit();
    }
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Search</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Additional CSS for the Advanced Search page */
        .search-container {
            text-align: center;
            margin: 20px auto;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .search-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
            text-align: left;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #AE0000; /* Darker gold color */
            color: #fff;
            padding: 10px 20px;
            border: 2px white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #fff; /* White background on hover */
            color: #AE0000; /* Darker gold text color on hover */
            border-color: #fff; /* White border on hover */
            transform: scale(1.05); /* Slight scale-up on hover for a subtle effect */
        }
        .search-container {
            text-align: center;
            margin: 20px auto;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .search-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border: 3px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #fff;
            color: #000;
        }

        .form-group select:hover {
            border-color: #AE0000;
        }

        /* Style the options within the dropdown */
        .form-group select option {
        background-color: #AE0000; /* Background color for options */
        color: #fff; /* Text color for options */
        padding: 5px; /* Padding for better spacing */
        border: 1px solid #000; /* Subtle border */
        font-family: Arial, sans-serif; /* Font selection */
        font-size: 16px; /* Font size */
        transition: background-color 0.3s, color 0.3s; /* Add transition for hover effect */
        }

    .form-group select option:hover {
        background-color: #AE0000; /* Background color on hover */
        color: #fff; /* Text color on hover */
        }

        button[type="submit"] {
            background-color: #AE0000;
            color: #000;
            padding: 10px 20px;
            border: 2px solid black;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.3s;
        }

        button[type="submit"]:hover {
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
    <div class="search-container">
            <h2>Advanced Search</h2>
            <br>
            <form action="search_results.php" method="post">
                <div class="form-group">
                    <label for="author">Authors:</label>
                    <select name="author" id="author">
                        <option value="default">Select an Author</option>
                        <?php
                        // Establish a database connection
                        include 'connection.php';

                        // Retrieve unique author values from the bookinfo dataset
                        $authorQuery = "SELECT DISTINCT author FROM bookinfo";
                        $authorResult = mysqli_query($conn, $authorQuery);

                        if (mysqli_num_rows($authorResult) > 0) {
                            while ($authorRow = mysqli_fetch_assoc($authorResult)) {
                                echo '<option value="' . $authorRow['author'] . '">' . $authorRow['author'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="genre">Subjects:</label>
                    <select name="genre" id="genre">
                        <option value="default">Select a Subject</option>
                        <?php
                        // Retrieve unique genre values from the bookinfo dataset
                        $genreQuery = "SELECT DISTINCT genre FROM bookinfo";
                        $genreResult = mysqli_query($conn, $genreQuery);

                        if (mysqli_num_rows($genreResult) > 0) {
                            while ($genreRow = mysqli_fetch_assoc($genreResult)) {
                                echo '<option value="' . $genreRow['genre'] . '">' . $genreRow['genre'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ratings">Ratings:</label>
                    <select name="ratings" id="ratings">
                        <option value="default">Select a Rating</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <button type="submit">Search</button>
            </form>
        </div>
    </main>
</body>
</html>
