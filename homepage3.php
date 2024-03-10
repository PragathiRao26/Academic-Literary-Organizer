<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cardo&display=swap" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .bg-image {
            background-image: url("campus.jpg");
            filter: blur(4px);
            -webkit-filter: blur(4px);
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

        ul li {
            list-style: none;
            margin: 0 auto;
            display: inline-block;
            position: relative;
            text-decoration: none;
            text-align: center;
            font-family: arvo;
        }

        li a {
            color: black;
        }

        li a:hover {
            color: #AE0000;
        }

        li:hover {
            cursor: pointer;
        }

        ul li ul {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            left: 0;
            display: none;
            background: white;
        }

        ul li:hover > ul,
        ul li ul:hover {
            visibility: visible;
            opacity: 1;
            display: block;
            min-width: 250px;
            text-align: left;
            padding-top: 20px;
            box-shadow: 0px 3px 5px -1px #ccc;
        }

        ul li ul li {
            clear: both;
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
            border-style: none;
        }

        ul li ul li a:hover {
            padding-left: 10px;
            border-left: 2px solid #AE0000;
            transition: all 0.3s ease;
        }

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

        a {
            text-decoration: none;
            &:hover {
                color: #AE0000;
            }
        }

        .submit_button {
            margin-top: 20px;
            background-color: #AE0000;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 10px;
            cursor: pointer;
        }

        .container {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .option-box {
            background-color: #ddd;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
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
            <div class="container">
                <nav role="navigation" class="primary-navigation">
                    <ul>
                        <li id="selectedOption">
                            <div class="option-box">
                                <a href="#">Select an option &dtrif;</a>
                            </div>
                            <ul class="dropdown">
                                <li><a href="#" onclick="setOption('Study Materials')">Study Materials</a></li>
                                <li><a href="#" onclick="setOption('Search Books')">Search Books</a></li>
                                <li><a href="#" onclick="setOption('Scheduler')">Scheduler</a></li>
                                <li><a href="#" onclick="setOption('Discussion Forum')">Discussion Forum</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <button class="submit_button" id="submitButton" onclick="submitOption()">Submit</button>
            </div> 
        </div>
    </div>
</section>

<script>
    function setOption(option) {
        document.getElementById('selectedOption').innerHTML = `<div class="option-box"><a href="#">${option} &dtrif;</a></div>`;
    }

    function submitOption() {
        const selectedOption = document.getElementById('selectedOption').innerText.trim().replace('&dtrif;', '');
        alert('Selected option: ' + selectedOption);
        document.getElementById('selectedOption').innerHTML = '<div class="option-box"><a href="#">Select an option &dtrif;</a></div>';
    }
</script>

</body>
</html>










