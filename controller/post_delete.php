<?php 
session_start();
require_once("../config/connection.php");

$post_id = $_GET["post_id"];
$sql = "SELECT * FROM posts WHERE id = $post_id";
$row = mysqli_query($db, $sql);
$result = mysqli_fetch_assoc($row);
$post_owner = $result["user_id"];
print_r($post_owner);
if($_SESSION["user_id"] == $post_owner) {
    $sql = "DELETE FROM posts WHERE id = $post_id";

    $affected = mysqli_query($db, $sql);

    header("Location: ../user-info.php");

} else {

    header("Location: ../user-info.php");

}


?>