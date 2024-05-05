<?php
    session_start();

	if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['type'] === 'student' || $_SESSION['type'] === 'teacher') {
        header("Location: login.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cardo&display=swap" rel="stylesheet">
</head>
<body>
<div class="bg-image"></div>
<header>
    <div class="logo">
        <div class="logo_text">
            <div style="font-family: 'argue_demo'; font-size: 32px; color:white;">Academic Literary Organizer</div>
        </div>
    </div>
</header>

<section class="home">
    <div class="form_container">
    <div class="form login_form">
    <h2 style="margin-top: 0px;">Welcome Admin<br>Select an Option</h2>
    <div class="container">
        <div class="dropdown">
            <button class="option-btn dropbtn">Options <span class="arrow">&#9662;</span></button>
            <div class="dropdown-content">
                <a href="userupdate.php">Single User Update</a>
                <a href="userupdate2.php">Multiple User Updates</a>
                <a href="syllabusupdate.php">Single Subject Update</a>
                <a href="syllabusupdate2.php">Multiple Subject Updates</a>
                <a href="nav.php">Study Materials</a>
                <a href="books.php">Search Books</a>
                <a href="todo.php">Scheduler</a>
                <a href="discuss.php">Discussion Forum</a>
            </div>
        </div>
        <br>
    </div> 
</div>
    </div>
</section>
</body>
</html>
