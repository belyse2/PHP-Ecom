<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "phpecom";

// Creating the database connection
$conn = mysqli_connect($host, $username, $password,$dbname);

// checking database connection
if (!$conn)
{
    die("Connection Failed".mysqli_error());
}
else{
    echo "Connection";
}
?>