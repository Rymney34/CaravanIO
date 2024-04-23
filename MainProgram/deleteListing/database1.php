<?php
$host = "localhost"; //database host
$username = "root"; //database username
$password = ""; //database password
$database = "assignment"; //database name

// Create connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Return the mysqli connection object
return $mysqli;
?>
