<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'assignment';

$mysqli = new mysqli ($host,$user,$pass,$db_name);
if ($mysqli->connect_errno) {
    die("Unable to connect: " . $mysqli->connect_error);
}
return $mysqli;
?>
