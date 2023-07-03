<?php 
require_once("../config/connection.php");
$comment = $_POST["comment"];
$user_id = $_POST["user_id"];
$post_id = $_POST["post_id"];


$sql = "INSERT INTO comments(comment, user_id, post_id) VALUES('$comment', '$user_id', '$post_id')";
$affected = mysqli_query($db, $sql);

$sql = "SELECT COUNT(*) AS count FROM comments WHERE post_id = '$post_id'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);

echo $row["count"];



?>