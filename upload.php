<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: signup.php"); 
    exit();
}
require 'connection.php';

if (isset($_POST["submit"])) {
    $bname = $_POST["bname"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $name = $_SESSION["name"];
    $totalrating = 5; // Initialize totalrating to 0
    $rno = 1; // Initialize rno to 0

    if ($_FILES["image"]["error"] == 4) {
        echo "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (!in_array(strtolower($imageExtension), $validImageExtension)) {
            echo "<script> alert('Invalid Image Extension'); </script>";
        } elseif ($fileSize > 1000000) {
            echo "<script> alert('Image Size Is Too Large'); </script>";
        } else {
            $newImageName = uniqid();
            $newImageName1=$newImageName. '.' . $imageExtension;

            move_uploaded_file($tmpName, 'img/' . $newImageName1);
        }
    }
    if ($_FILES["files"]["error"] == 4) {
        echo "<script> alert('File Does Not Exist'); </script>";
    } else {
        $fileName = $_FILES["files"]["name"];
        $fileSize = $_FILES["files"]["size"];
        $tmpName = $_FILES["files"]["tmp_name"];

        $validFilesExtension = ['pdf'];
        $filesExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (!in_array(strtolower($filesExtension), $validFilesExtension)) {
            echo "<script> alert('Invalid File Extension'); </script>";
        } else {
            $newFileName = uniqid();
            $newFileName1=$newFileName. '.' . $filesExtension;

            move_uploaded_file($tmpName, 'file/' . $newFileName1);
            
            // Insert book information into the bookinfo table
            $query = "INSERT INTO `bookinfo` (`bname`, `author`, `genre`, `totalrating`, `rno`, `name`, `image`, `pdf`) VALUES ('$bname', '$author', '$genre', $totalrating, $rno, '$name', '$newImageName', '$newFileName')";
            if (mysqli_query($conn, $query)) {
                echo "<script> alert('Successfully Added'); </script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Upload Book</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
        }
        /* header {
            background-color: #AE0000;
            padding: 10px 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            align-items: center;
        }
        .navbar-logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        } */
        /* .navbar-menu ul {
            list-style: none;
            padding: 0;
        }
        .navbar-menu ul li {
            display: inline;
            margin-right: 20px;
        }
        .navbar-menu ul li a {
            text-decoration: none;
            color: #fff;
        } */
        .upload-form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        .upload-form label {
            font-size: 16px;
            display: block;
            margin-top: 20px;
        }
        .upload-form input[type="text"], .upload-form input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 5px;
        }
        .upload-form button[type="submit"] {
            background-color: #AE0000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .upload-form button[type="submit"]:hover {
            background-color: #fff;
            color: #AE0000;
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
        <form class="upload-form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
            <label for="bname">Book Name: </label>
            <input type="text" name="bname" id="bname" required value=""> <br>
            <label for="author">Author: </label>
            <input type="text" name="author" id="author" required value=""> <br>
            <label for="genre">Subject: </label>
            <input type="text" name="genre" id="genre" required value=""> <br>
            <label for="image">Image: </label>
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" value=""> <br>
            <label for="files">File (PDF): </label>
            <input type="file" name="files" id="files" accept=".pdf" value=""> <br>
            <button type="submit" name="submit">Submit</button>
        </form>
        <br>
    </main>
</body>
</html>