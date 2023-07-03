<?php include_once("partials/header.php"); ?>
<?php 
require_once("config/connection.php");
$post_id = $_GET["post_id"];
$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
if($result->num_rows == 0) {
    header("Location: ../social");
}
if(!isset($_GET["post_id"])) {
    header("Location: ../social");
} 
if($_SESSION["user_id"] != $row["user_id"]) {
    header("Location: ../social");
}
?>
<form method="POST" name="postUpdate" id="postUpdate" enctype="multipart/form-data" action="controller/update_post.php">
<section id="post-something" class="posting-details" style="margin-top: 30px;">
    <h1>Update your post</h1>
    <textarea name="post_data" placeholder="What's on your mind"><?php echo $row["post_data"] ?></textarea>
    <br>
    <label class="custom-file-upload">
        image
    <input type="file" name="post_img" name="post_img">
    </label>
    <input type="hidden" name="img_address" value="<?php echo $row["post_img"] ?>" />
    <input type="hidden" value="<?php echo $row["id"]; ?>" name="post_id"/>
    <input type="hidden" value="<?php echo date("d/M/Y") ?>" name="created_date" />
    <br>
    <input type="submit" style="color: black;" value="Post">
</section>
</form>
<?php include_once("partials/footer.php"); ?>