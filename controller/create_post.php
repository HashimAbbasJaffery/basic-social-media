<?php 

require_once("../config/connection.php");

$user_id = $_POST['user_id'];
$post_data = $_POST['post_data'];
$post_img = basename($_FILES['post_img']["name"]) ?? "";
$created_date = $_POST['created_date'];

$sql = "INSERT INTO 
    posts(user_id, post_data, post_img, created_data) 
        VALUES ('$user_id', '$post_data', '$post_img', '$created_date')";


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["post_img"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

move_uploaded_file($_FILES["post_img"]["tmp_name"], $target_file);


$affected = mysqli_query($db, $sql);

header('Location: ../index.php');


?>