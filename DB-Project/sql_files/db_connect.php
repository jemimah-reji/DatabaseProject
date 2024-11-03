<?php
$servername = 127.0.0.1;
$port = 3306;
$username = "root";
$password = "";  
$dbname = "Shopping_System";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
