<?php
    session_start();

	if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        header("Location: login.php");
        exit();
    }
    if(isset($_POST['semester']) && isset($_POST['branch'])) {
        $_SESSION['semester'] = $_POST['semester'];
        $_SESSION['branch'] = $_POST['branch'];
        header("Location: nav2.php");
        exit();
    } elseif(isset($_POST['submit'])) {
        echo "<script>alert('Please select both Semester and Branch.');</script>";
    }
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "academic_records";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch distinct semesters
    $semester_query = "SELECT DISTINCT Semester FROM subjectdata";
    $semester_result = $conn->query($semester_query);

    // Fetch distinct branches
    $branch_query = "SELECT DISTINCT Branch FROM subjectdata";
    $branch_result = $conn->query($branch_query);

    // Close connection
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cardo&display=swap" rel="stylesheet">
    <script>
        function submitForm() {
            var semester = document.getElementById("semester").value;
            var branch = document.getElementById("branch").value;
            if (semester && branch) {
                return true;
            } else {
                alert("Please select both Semester and Branch.");
                return false;
            }
        }
    </script>
    <style>
        .custom-select {
    margin-bottom: 20px;
}

.custom-select label {
    color: #fff;
    font-family: 'Cardo', serif;
    font-size: 18px;
    margin-bottom: 8px;
}

.select-wrapper {
    position: relative;
    width: 100%;
}

.select-wrapper select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    color: #710000;
    font-size: 16px;
    cursor: pointer;
}

.select-wrapper select:focus {
    outline: none;
    border-color: #AE0000;
}

.custom-arrow {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 6px solid #710000;
    pointer-events: none;
}

.submit_btn {
    background-color: #AE0000;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-family: 'Cardo', serif;
    font-size: 18px;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
    width: 100%;
}

.submit_btn:hover {
    background-color: #710000;
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
        <form method="post" onsubmit="return submitForm()">
            <div class="form login_form">
                <h2>Select Options</h2>
                <div class="input_group">
                    <div class="custom-select">
                        <label for="semester">Select Semester:</label>
                        <div class="select-wrapper">
                            <select id="semester" name="semester">
                                <option value="">Select Semester</option>
                                <?php while($row = $semester_result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['Semester']; ?>"><?php echo $row['Semester']; ?></option>
                                <?php } ?>
                            </select>
                            <span class="custom-arrow"></span>
                        </div>
                    </div>
                    <div class="custom-select">
                        <label for="branch">Select Branch:</label>
                        <div class="select-wrapper">
                            <select id="branch" name="branch">
                                <option value="">Select Branch</option>
                                <?php while($row = $branch_result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['Branch']; ?>"><?php echo $row['Branch']; ?></option>
                                <?php } ?>
                            </select>
                            <span class="custom-arrow"></span>
                        </div>
                    </div>
                </div>
                <div class="button_container">
                    <button type="submit" name="submit" class="submit_btn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</section>


</body>
</html>


