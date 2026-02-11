<?php
function connectDB($db){
$servername = "localhost";
$username = "root";
$password = "";
$database = $db;

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    return "Connection failed: " . mysqli_connect_error();
}
return $conn;
}
