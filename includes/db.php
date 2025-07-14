<?php
$host = "localhost";    // Database host (e.g., localhost or your server address)
$dbname = "address_book"; // Database name
$username = "root";     // Database username (default is usually root)
$password = "";         // Database password (leave empty for default MySQL setup)

// Create connection using MySQLi (procedural)
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
