<?php
$servername = "localhost";
$username = "root"; // Your MySQL username (default for XAMPP)
$password = ""; // Your MySQL password (default empty for XAMPP)
$dbname = "bookshop_db"; // The database you just created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, stop script execution and display error
    die("Connection failed: " . $conn->connect_error);
}

// If connection is successful, you can now use the $conn object
// to perform database operations (e.g., queries, inserts, updates)
?>
