<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "daffodils_school";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn .mysqli_connect_error());
}
echo "Connected successfully";
?>