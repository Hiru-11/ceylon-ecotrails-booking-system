<?php
// db.php - Database connection file

// Database credentials
$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "trekking";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// set character set to UTF-8 (This is applied to support any languages and prevent broken characters or weird symbols)
$conn->set_charset("utf8");

?>
