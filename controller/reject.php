<?php 


require_once('../config/connection.php');

$user_id = str_replace("request-", "",$_POST['user_id']);
$friend_id = $_POST['friend_id'];

$sql = "DELETE FROM user_friends WHERE user_id = '$user_id' AND friend_id = '$friend_id'";

$affected = mysqli_query($db, $sql);

if($affected) {
    echo 1;
    return;
}

echo 0

?>