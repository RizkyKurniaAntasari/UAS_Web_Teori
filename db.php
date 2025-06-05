<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "oprec";

$conn = mysqli_connect($host,$user,$password,$db);

if(!$conn){
    die("Error Connection : " . mysqli_connect_error());
}
?>