<?php
$servername = "localhost";  // XAMPP default
$username = "root";         // XAMPP default MySQL username
$password = "";             // XAMPP default MySQL password (empty)
$dbname = "Shopping_System"; // Ensure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
