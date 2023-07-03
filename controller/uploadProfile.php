<?php 
require_once("../config/connection.php");
session_start();


$target_dir = "../profile_image/";
$target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

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


// uploads file

if ($uploadOk == 0) {
    echo 0;
    return;
} else {
    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
    
    } else {
        echo 0;
        return;
    }
  }

  
$id = $_SESSION['user_id'];
$filename = basename($_FILES["profile_pic"]["name"]);
$sql = "UPDATE users SET profile_img = '$filename' WHERE id = $id";
$result = mysqli_query($db, $sql);

echo $filename;

?>