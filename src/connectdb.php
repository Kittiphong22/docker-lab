<?php
$servername = "mysql"; //"mysql"
$username = "root";
$password = "kittiphong1234";
$db = "blogdb";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";