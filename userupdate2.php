<?php
require 'vendor/autoload.php'; // Include the PhpSpreadsheet autoloader

use PhpOffice\PhpSpreadsheet\IOFactory;
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['type'] === 'student' || $_SESSION['type'] === 'Student') {
      header("Location: login.php"); 
      exit();
  }
  function encryptPassword($password) {
    return base64_encode($password);
}

  // INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'But Books', 'Please buy books from Store', current_timestamp());
$insert = false;
$update = false;
$delete = false;
// Connect to the Database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "academic_records";  

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `userdata` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset( $_POST["snoEdit"])){
  // Update the record
    $sno = $_POST["snoEdit"];
    $Emailid = $_POST["titleEdit"];
    $Password = $_POST["descriptionEdit"];
    $Name = $_POST["name1Edit"];
    $Type = $_POST["type1Edit"];

  // Sql query to be executed
  $sql = "UPDATE `userdata` SET `Emailid` = '$Emailid', `Type` = '$Type' , `name` = '$Name'  WHERE `userdata`.`sno` = $sno";
  $result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
}
else{
    echo "We could not update the record successfully";
}
}
else{
  if (isset($_FILES["excelFile"]) && $_FILES["excelFile"]["error"] == UPLOAD_ERR_OK) {
    // Get the uploaded file details
    $uploadedFile = $_FILES["excelFile"];
    $fileName = $uploadedFile["name"];
    $fileTmpName = $uploadedFile["tmp_name"];
    // Check if the file is an Excel file
    $allowedExtensions = ['xls', 'xlsx'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    if (in_array(strtolower($fileExtension), $allowedExtensions)) 
    {
        // Load the Excel file
        $spreadsheet = IOFactory::load($fileTmpName);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();// Insert data into the database
        $o=1;
        foreach ($data as $row) {
          if($o==0)
          {
            $sql = "INSERT INTO `userdata` (`Emailid`, `Password`, `Type`, `name`) VALUES ('" . implode("', '", $row) . "')";
            $result = mysqli_query($conn, $sql);
          }
          else{
            $o--;
          }
        }
        if($result){ 
          $insert = true;
        }
        else{
          echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
        } 
    } 
    else {
        echo "Invalid file format. Please upload an Excel file with extensions .xls or .xlsx.";
      }
    } 
    else {
    echo "Error uploading the file.";
    }
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <!--style.css-->
  <link rel="stylesheet" href="sty.css">
  <!--fontawesome - for 5 social media icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>


  <title>User Updates</title>
  <style>

@import url('https://fonts.googleapis.com/css2?family=Marcellus&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;1,100;1,200;1,300&display=swap'); 

header {
    background: linear-gradient(to right, #710000, #AE0000);
    color: #fff;
    padding: 20px;
    text-align: center;
    position: relative;
    z-index: 1;
}

.uuflex {
  display: block;
}

.uuhd{
    font-family: 'Marcellus';
    font-size:40px;
    display: flex;
    justify-content: center;
    margin-top: 7px;
    font-style: bold;
    text-align:center;
}

.notetitle,.notedesc{
    font-family: 'Marcellus';
    font-size:22px;
    display: flex;
    margin-top: 5px;
    font-style: bold;
}

.addnotebtn{
    display: flex;
    justify-content: center;
    text-align: center;
    cursor:pointer;
    background-color:#b7202e;
    padding:5px 5px;
    margin:8px;
    /* margin-left: 46%;
    margin-right: auto; */
    border-color: red;
    border-radius: 10px;
    height:40px;
    width:120px;
    font-family: 'Fira Sans';
    font-size: 20px;
    color:white;
}

.tblcontent{
  font-family: 'Fira Sans', sans-serif;
  font-weight: 2000; 
}

.editbtn,.delbtn{
  text-align: center;
  cursor:pointer;
  color:white;
  background-color:#b7202e;
  padding:10px 10px;
  margin:auto;
  border-color: red;
  font-family: 'Fira Sans';
  font-size: 15px;
}

textarea{
  height:auto;
}

</style>

</head>

<body class="img">
 

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this User Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="userupdate2.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title" class="notedesc">Email-Id</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc" class="notedesc">Password</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"rows="1" ></textarea>
            </div> 
            <div class="form-group">
              <label for="desc" class="notedesc">Name</label>
              <textarea class="form-control" id="name1Edit" name="name1Edit" rows="1" ></textarea>
            </div> 
            <div class="form-group">
              <label for="desc" class="notedesc">Type(admin/student)</label>
              <textarea class="form-control" id="type1Edit" name="type1Edit" rows="1" ></textarea>
            </div> 
            
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><img src="/crud/logo.svg" height="28px" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>

      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav> -->

  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='position: absolute; top: 0; left: 0; width: 100%; z-index: 2;'>
    <strong>Success!</strong> Your user data has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='position: absolute; top: 0; left: 0; width: 100%; z-index: 2;'>
    <strong>Success!</strong> Your user data has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($update){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='position: absolute; top: 0; left: 0; width: 100%; z-index: 2;'>
  <strong>Success!</strong> Your user data has been updated successfully
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
  </button>
</div>";
  }
  ?>
  <header>
    <div class="logo">
        <div class="logo_text">
            <div style="font-family: 'argue_demo'; font-size: 32px; color:white;">User Updates</div>
        </div>
    </div>
  </header>
  <div class="container uuflex my-4">
    <br>
    <form action="userupdate2.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
      <label for="excelFile" class="notedesc">Upload Excel File</label>
      <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xlsx, .xls">
      <small id="fileHelp" class="form-text text-muted">Upload Excel files with extensions .xls or .xlsx.<br>Columns should be: email, password, name, type</small>
      </div>
    <button type="submit" class="btn addnotebtn">Add Data</button>
    </form>
  </div>
  <br>

  <div class="container my-4">
    <table class="table tblcontent" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Email</th>
          <th scope="col">Password</th>
          <th scope="col">Name</th>
          <th scope="col">Type</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $sql = "SELECT * FROM `userdata`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['Emailid'] . "</td>
            <td>". encryptPassword($row['Password']) . "</td>
            <td>". $row['name'] . "</td>
            <td>". $row['Type'] . "</td>
            <td><button class='edit btn btn-sm btn-primary editbtn' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary delbtn' id=d".$row['sno'].">Delete</button>  </td>
          </tr>";
        } 
          ?>
      </tbody>
    </table>
  </div>
  <br>
    <hr>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        name1 = tr.getElementsByTagName("td")[2].innerText;
        type1 = tr.getElementsByTagName("td")[3].innerText;
        console.log(title, description,name1, type1);
        titleEdit.value = title;
        descriptionEdit.value = description;
        type1Edit.value = type1;
        name1Edit.value = name1;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this data?")) {
          console.log("yes");
          window.location = `userupdate2.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>
