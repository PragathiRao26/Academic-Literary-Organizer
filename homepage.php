<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cardo&display=swap" rel="stylesheet">
</head>
<body>

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
            <form method="POST" class="dropdown_form">
                <div class="dropdown">
                    <select name="option" class="dropdown_select">
                        <option value="select" disabled selected>Select an option</option>
                        <option value="study_materials">Study Materials</option>
                        <option value="search_books">Search Books</option>
                        <option value="scheduler">Scheduler</option>
                        <option value="discussion_forum">Discussion Forum</option>
                    </select>
                </div>
                <input type="submit" name="submit" value="Submit" class="hover_color_change">
            </form>
            <?php
            if(isset($_POST['submit'])) {
                $selected_option = $_POST['option'];
                echo "<div class='bg-text'>You selected: $selected_option</div>";
            }
            ?>
        </div>
    </div>
</section>

<div class="bg-image"></div>

<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    * {
        box-sizing: border-box;
    }

    .bg-image {
        background-image: url("campus.jpg");
        filter: blur(8px);
        -webkit-filter: blur(8px);
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        z-index: -1;
    }

    /* Position text in the middle of the page/image */
    .bg-text {
        background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
        color: #710000;
        font-weight: bold;
        border-radius: 10px;
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        padding: 10px 20px;
        text-align: center;
    }

    /* Style for the dropdown form */
    .dropdown_form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        text-align: center;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown_select {
        background-color: #f2f2f2;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        outline: none;
        transition: background-color 0.3s ease;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .dropdown_select:hover {
        background-color: #ddd;
    }

    .dropdown_select:focus {
        background-color: #ccc;
    }

    .hover_color_change {
        background-color: #AE0000;
        border: none;
        border-radius: 5px;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .hover_color_change:hover {
        background-color: #710000;
    }
</style>

<script>
    // JavaScript for color highlighting effect
    const dropdown = document.querySelector('.dropdown_select');
    dropdown.addEventListener('change', function() {
        dropdown.style.backgroundColor = "#ccc"; // Change color when dropdown value changes
    });
</script>

</body>
</html>



