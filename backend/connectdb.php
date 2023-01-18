<?php
$servername = "45.144.164.52:13306";
$username = "root";
$password = "Rung_tom003";
$database = "reserve_space";
$port = "13306";

// Create connection
$conn = mysqli_connect($servername, $username, $password,);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>