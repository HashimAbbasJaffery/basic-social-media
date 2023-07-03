<?php

require_once("../config/connection.php");

$password = $_POST["password"];
$email = $_POST["email"];
$username = $_POST["username"];

$sql = "INSERT INTO users (password, email, username) VALUES ('$password', '$email', '$username')";

$affected = mysqli_query($db, $sql);

$_SESSION["is_created"] = TRUE;

header("Location: ../login.php");




?>