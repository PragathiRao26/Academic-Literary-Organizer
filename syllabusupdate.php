<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['type'] === 'student' || $_SESSION['type'] === 'Student') {
      header("Location: login.php"); 
      exit();
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
  $sql = "DELETE FROM `subjectdata` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
if (isset( $_POST["snoEdit"])){
  // Update the record
    $sno = $_POST["snoEdit"];
    $Semester = $_POST["titleEdit"];
    $Branch = $_POST["descriptionEdit"];
    $Subject = $_POST["name1Edit"];

  // Sql query to be executed
  $sql = "UPDATE `subjectdata` SET `Semester` = '$Semester', `Branch` = '$Branch', `Subject` = '$Subject'  WHERE `subjectdata`.`sno` = $sno";
  $result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
}
else{
    echo "We could not update the record successfully";
}
}
else{
    $Semester = $_POST["title"];
    $Branch = $_POST["description"];
    $Subject = $_POST["name1"];

  // Sql query to be executed
  $sql = "INSERT INTO `subjectdata` (`Semester`, `Branch`, `Subject`) VALUES ('$Semester', '$Branch', '$Subject')";
  $result = mysqli_query($conn, $sql);

   
  if($result){ 
      $insert = true;
  }
  else{
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
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


  <title>Syllabus Updates</title>
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

.uuflex{
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
          <h5 class="modal-title" id="editModalLabel">Edit this Subject Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="syllabusupdate.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title" class="notedesc">Semester</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc" class="notedesc">Branch</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"rows="1" ></textarea>
            </div> 
            <div class="form-group">
              <label for="desc" class="notedesc">Subject</label>
              <textarea class="form-control" id="name1Edit" name="name1Edit" rows="1" ></textarea>
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

  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='position: absolute; top: 0; left: 0; width: 100%; z-index: 2;'>
    <strong>Success!</strong> Your subject has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='position: absolute; top: 0; left: 0; width: 100%; z-index: 2;'>
    <strong>Success!</strong> Your subject has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='position: absolute; top: 0; left: 0; width: 100%; z-index: 2;'>
    <strong>Success!</strong> Your subject has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <header>
    <div class="logo">
        <div class="logo_text">
            <div style="font-family: 'argue_demo'; font-size: 32px; color:white;">Syllabus Updates</div>
        </div>
    </div>
  </header>
  <div class="container uuflex my-4">
    
    <br>
    <form action="syllabusupdate.php" method="POST">
      <div class="form-group">
        <label for="title" class="notetitle">Semester</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>

      <div class="form-group">
        <label for="desc" class="notedesc">Branch</label>
        <textarea class="form-control" id="description" name="description" rows="1"></textarea>
      </div>

      <div class="form-group">
        <label for="title" class="notetitle">Subject</label>
        <input type="text" class="form-control" id="name1" name="name1">
      </div>
      <br>
      <button type="submit" class="btn addnotebtn">Add Data</button>
    </form>
    <br>
  </div>

  <div class="container my-4">

    <table class="table tblcontent" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Semester</th>
          <th scope="col">Branch</th>
          <th scope="col">Subject</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $sql = "SELECT * FROM `subjectdata`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['Semester'] . "</td>
            <td>". $row['Branch'] . "</td>
            <td>". $row['Subject'] . "</td>
            <td><button class='edit btn btn-sm btn-primary editbtn' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary delbtn' id=d".$row['sno'].">Delete</button>  </td>
          </tr>";
        } 
          ?>


      </tbody>
    </table>
  </div>
  <br><br>
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
    console.log(title, description,name1);
    titleEdit.value = title;
    descriptionEdit.value = description;
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
          window.location = `syllabusupdate.php?delete=${sno}`;
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
