<?php

$host = "localhost";
$user = "root";
$password = "";

// Create connection
$conn = mysqli_connect($host, $user, $password);

if(!$conn){
    die("Connection Failed");
}

// Create database automatically
$sql = "CREATE DATABASE IF NOT EXISTS shop_management";
mysqli_query($conn, $sql);

// Select database
mysqli_select_db($conn, "shop_management");

// Create table automatically
$table = "CREATE TABLE IF NOT EXISTS employees(
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100),
contact VARCHAR(50),
username VARCHAR(100),
password VARCHAR(100)
)";

mysqli_query($conn, $table);

?>
