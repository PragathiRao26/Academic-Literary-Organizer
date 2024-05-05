<?php
$servername="localhost";
$username="root";
$password="";
$dbname="academic_records";
$conn=mysqli_connect($servername,$username,$password,$dbname);
if(!$conn)
{
    echo mysqli_connect_error();    
}
?>