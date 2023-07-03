<?php 
require_once("../config/connection.php");
$post = $_POST["post_data"];
$post_id = $_POST["post_id"];
$post_img = $_FILES["post_img"]["name"];
$img_address = $_POST["img_address"];

$sql = "UPDATE posts SET post_data = '$post'";

if($post_img) {
    $sql .= ", post_img = '$post_img'";

    

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["post_img"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["post_img"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
}


// uploads file

if ($uploadOk == 0) {
    return;
} else {
    if (move_uploaded_file($_FILES["post_img"]["tmp_name"], $target_file)) {
    
    } else {
        return;
    }
  }
}

$sql .= " WHERE id = $post_id";

$affected = mysqli_query($db, $sql);

header("Location: ../user-info.php");


?>