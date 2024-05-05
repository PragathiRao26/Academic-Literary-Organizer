<?php

session_start();

$serial = 1;
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['semester']) || !isset($_SESSION['branch'])) {
    header("Location: nav.php");
    exit();
}
if (!isset($_SESSION['subject']) || !isset($_SESSION['option']) ) {
    header("Location: nav2.php");
    exit();
}
$semester = $_SESSION["semester"];
$branch = $_SESSION["branch"];
$option=$_SESSION['option'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "academic_records";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the query
    $query = "SELECT id, Link, date, name , title FROM linksdata WHERE semester = ? AND branch = ? AND option = ? AND subject= ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);
    
    // Bind the session variables to the statement parameters
    $stmt->bind_param("ssss", $_SESSION['semester'], $_SESSION['branch'],  $_SESSION['option'], $_SESSION['subject']);
    
    // Execute the statement
    $stmt->execute();
    
    // Bind the result variables
    $stmt->bind_result($id, $link, $uploadDate, $facultyName, $title);
    
    $counter = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav3.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <title>Navigation</title>
</head>

<!-- <div class="arm" style="font-family: serif; font-size: 20px; padding-top:20px; padding-left:20px;"><div style="font-size: 65px;font-family: serif; margin-top:-16px; margin-right:-4px;">A</div>cademic Records<br> Management System</div> -->

<body>
<div class="container">
    <div class="table-container">
        <!-- <table class="table"> -->
        <table>
            <thead>
                <div class="gatewaytitle"><?php echo "".$_SESSION['subject']; ?>
        <br></div>
        <div class="tit">
        <?php echo "Semester ".$semester."-".$branch; ?>
    </div>
                <tr>
                    <th class="the">Sr No.</th>
                    <th class="the">Title</th>
                    <?php if ($_SESSION['type'] == 'admin'): ?>
                        <th class="the">Upload Date</th>
                        <th class="the">Uploaded By</th>
                        <!-- <th class="the">Upload File</th> -->
                    <?php endif; ?>
                    <th class="the">View</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while ($stmt->fetch()) 
                    { 
                ?>
                    <tr>
                        <td data-label="Sr No."><?php echo $counter; ?></td>
                        <td><?php echo $title; ?></td>
                        <?php if ($_SESSION['type'] == 'admin'): ?>
                            <td data-label="Upload Date"><?php echo $uploadDate; ?></td>
                            <td data-label="Faculty Name"><?php echo $facultyName; ?></td>
                            <!-- <td data-label="Upload File">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="link_id" value="<?php echo $serialNumber; ?>">
                                    <input type="file" name="file_upload" accept=".pdf,.doc,.docx">
                                    <button type="submit" class="btn">Upload</button>
                                </form>
                            </td> -->
                        <?php endif; ?>
                        <td data-label="Link">
                        <a href="http://<?php echo $link; ?>" class="btn">Link</a>
                        </td>
                    </tr>
                <?php 
                    $counter++;
                    } 
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="upload-delete-container">
    <div class="upload">
        <button type="button" class="collapsible">UPLOAD</button>
        <div class="content">
            <form method="POST" class="form">
                <input type="text" placeholder="Enter File Name" name="file_name">
                <input type="hidden" name="link_id" value="<?php echo $serialNumber; ?>">
                <input type="text" placeholder="Enter File Link" name="file_link">
                <button type="submit" class="btn2" name="upload">Upload</button>
            </form>
        </div>
    </div>

    
    <div class="delete">
        <button type="button" class="collapsible2">DELETE</button>
        <div class="content2">
            <form method="POST" class="form">
                <label for="referrer" id="label" style="color: black;">Select link you want to delete
                    <select id="referrer" name="referrer">
                        <option value="" style="color: black;">Select one</option>
                        <?php
                        if($_SESSION['type'] == 'student')
                        {
                        // Retrieve files based on faculty name, year, subject, etc.
                            $facultyName = $_SESSION['username'];
                            $semester = $_SESSION['semester'];
                            $branch = $_SESSION['branch'];
                            $subject = $_SESSION['subject'];
                            $type= $_SESSION['type'];

                            $stmt = $conn->prepare("SELECT title FROM linksdata WHERE faculty_name = ? AND semester = ? AND branch = ? AND subject = ? AND option = ?");
                            $stmt->bind_param("sssss", $facultyName, $semester, $branch, $subject,$option);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Generate options based on the retrieved files
                            while ($row = $result->fetch_assoc()) {
                                $title = $row['title'];
                                echo "<option value='$link' style='color: black;' class='black-text'>$title</option>";
                            }
                        }
                        elseif($_SESSION['type'] == 'admin')
                        {
                            $year = $_SESSION['year'];
                            $semester = $_SESSION['semester'];
                            $branch = $_SESSION['branch'];
                            $subject = $_SESSION['subject'];
                            $type= $_SESSION['type'];
                            $stmt = $conn->prepare("SELECT title FROM linksdata WHERE semester = ? AND branch = ? AND subject = ? AND option = ?");
                            $stmt->bind_param("ssss", $semester, $branch, $subject, $option);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Generate options based on the retrieved files
                            while ($row = $result->fetch_assoc()) {
                                $title = $row['title'];
                                echo "<option value='$link'>$title</option>";
                            }
                        }

                        $stmt->close();
                        ?>
                    </select>
                    <button type="submit" class="btn2" name="delete">Delete</button>
                </label>
            </form>
        </div>
    </div>
</div>
<script src="display2.js"></script>
<style>
    select#referrer option {
        color: black !important;
    }
</style>
</body>
</html>


<?php

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])) {
    // Handle file upload logic
    if ($_SESSION['type'] == 'student' || $_SESSION['type'] == 'admin') {
        // Check if a file was uploaded
        $file_name = $_POST['file_name'];
        $file_link = $_POST['file_link'];
        $date = date('Y-m-d');
        if($_SESSION['type'] == 'admin')
        {
        $facultyName = 'Admin';
        }
        elseif($_SESSION['type'] === 'student')
        {
        $facultyName = $_SESSION['username'];
        }
        $subject = $_SESSION['subject'];
        $branch=$_SESSION['branch'];
        $option=$_SESSION['option'];
        $semester=$_SESSION['semester'];
        $stmt = $conn->prepare("INSERT INTO linksdata (`Link`, `date`, `name`, `subject`, `branch`, `semester`, `option`, `title`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $file_link, $date, $facultyName, $subject, $branch, $semester, $option, $file_name);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Inserted successfully.";
        } else {
            echo "Error" . $stmt->error;
        }
        $stmt->close();
        }
?><script>
  
    window.location.href = window.location.href;
  
</script>
<?php
}
?>

<?php
// Check if the delete button was clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    // Get the selected file to delete
    $selectedFile = $_POST['referrer'];

    if (!empty($selectedFile)) {
        // Delete the file from the database
        $stmt = $conn->prepare("DELETE FROM linksdata WHERE Link = ?");
        $stmt->bind_param("s", $selectedFile);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Deleted successfully.";
        } else {
            echo "Error";
        }
        $stmt->close();
    }
?><script>
  
    window.location.href = window.location.href;
  
</script>
<?php
}
?>