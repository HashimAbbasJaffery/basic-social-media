<?php

require_once("../config/connection.php");
session_start();
$user_id = $_SESSION["user_id"];
$friend_id = $_POST["friend_id"];


$sql = "DELETE FROM user_friends WHERE (user_id = '$user_id' AND friend_id = '$friend_id') OR (user_id = '$friend_id' AND friend_id = '$user_id')";

$affected = mysqli_query($db, $sql);

header("Location: ../friends.php");



?>