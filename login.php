<?php
// all required variables defined here
session_start(); // start the session
session_unset();// unset all session variables
session_destroy();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
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
                <form method="POST" name="Logform" onsubmit="login.php">
                    <h2>Login</h2>
                    <div class="input_box">
                        <input type="email" name="email" placeholder="Enter your email" required />
                        <i class="uil uil-envelope-alt email"></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="password" placeholder="Enter your password" required />
                        <i class="uil uil-lock password"></i>
                    </div>
                    <div class="button_container">
                        <button class="loginbtn" type="submit">Submit</button>
                        <button class="signupbtn" onclick="location.href='signup.php';">Signup</button>
                    </div>
                </form>
            </div>
            <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academic_records";

// Checking if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Establishing a connection to the database
    $conn = new mysqli($servername,$username, $password, $dbname);

    // Checking if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieving the email and password from the form submission
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the email and password exist in the database
    $sql = "SELECT Type,name FROM Userdata WHERE Emailid = '$email' AND Password = '$password'";
    $result = $conn->query($sql);

    // Checking if a row was returned
    if ($result->num_rows > 0) {
        // Valid credentials
        $row = $result->fetch_assoc();
        $userType = $row['Type'];
	$_SESSION['type'] = $userType;
        $name = $row['name'];
	$_SESSION['username']=$name;      
        $_SESSION['loggedin'] = true;
                
        // Perform actions based on user type (student, teacher, admin)
        if ($userType === 'student' || $userType === 'Student') {
            // Student login logic
		echo '<script>window.location.href = "homepage.php";</script>';
        }
        elseif ($userType === 'admin'|| $userType === 'Admin') {
            // Admin login logic
            echo '<script>window.location.href = "adminpg.php";</script>';
        }
    } else {
        // Invalid credentials
        echo "<br><br><span style='color: red;'>Invalid email or password.</span>";
    }

    // Closing the database connection
    $conn->close();
}
?>
        </div>
    </section>
</body>
</html>
