<?php
$servername = "45.144.164.52";
$username = "root";
$password = "12345678";
$db = "reserve_space";
$port = "13306";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db,$port);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>