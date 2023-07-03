<?php 

session_start();
include("../config/connection.php");

    function like($user_id, $post_id, $db) {
        $sql = "INSERT INTO post_likes (user_id, post_id) VALUES ('$user_id', '$post_id')";
        $result = mysqli_query($db, $sql);
    }

    function unlike($user_id, $post_id, $db) {
        $sql = "DELETE FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id'";
        $result = mysqli_query($db, $sql);
    }
    
    $user_id = $_SESSION["user_id"];
    $post_id = $_POST["post_id"] ?? 0;
    $status = $_POST["status"];

    if($status == "0") {
        like($user_id, $post_id, $db);
    } else {
        unlike($user_id, $post_id, $db);
    }

    $sql = "SELECT count(*) as total_likes FROM post_likes WHERE post_id = '$post_id'";
    $data = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($data);
    $passThrough = [
        "post_id" => $post_id,
        "liked" => $row["total_likes"]
    ];
    echo json_encode($passThrough);

?>