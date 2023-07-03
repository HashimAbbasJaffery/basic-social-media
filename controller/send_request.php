<?php 

require_once("../config/connection.php");

$user_id = $_POST['user_id'];
$friend_id = $_POST['friend_id'];

$sql = "INSERT INTO user_friends(user_id, friend_id, is_accepted) VALUES ('$user_id', '$friend_id', 0)";

$affected = mysqli_query($db, $sql);

if($affected) {
    echo 1; 
    return;
}

echo 1;

?>