<?php 

$server = "localhost";
$username = "root";
$password = "";
$database = "smedia";

$db = mysqli_connect($server, $username, $password, $database);

if(!$db) {
    echo "Not Connected";
} 


?>