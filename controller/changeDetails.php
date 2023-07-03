<?php 
session_start();
require_once("../config/connection.php");

$first_column = $_POST["first_column"];
$second_column = $_POST["second_column"];


$first_value = $_POST["first_value"];
$second_value = $_POST["second_value"];

$user_id = $_SESSION["user_id"];



$sql = "UPDATE users SET $first_column = '$first_value', $second_column = '$second_value' WHERE id = $user_id";
$affected = mysqli_query($db, $sql);

?>