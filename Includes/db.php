<?php

$db_server = 'localhost';
$db_username = 'root';
$db_password = '22092209';
$db_name = 'transportdb';


$conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}
// Set the character set to UTF-8


?>