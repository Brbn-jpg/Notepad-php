<?php 

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "notes_app";

if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
  die("failed to connect!");
}
?>