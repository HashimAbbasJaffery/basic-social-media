<?php include_once("config/connection.php"); ?>          
<?php include_once("partials/header.php"); ?>  
<?php 
    session_start(); 
    
    $id = (isset($_GET['user'])) ? $_GET["user"] : $_SESSION["user_id"]; 
    $sql = "SELECT * FROM users WHERE id = $id";
    $userDetail = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($userDetail);
?>
        <div class="wrapper">
            <div class="user-info">
                <div class="profile-pic">
                    <?php 
                        $url = "https://placehold.co/100x100";
                        if($user["profile_img"]) {
                            $url = "profile_image/" . $user["profile_img"];
                        }
                    ?>
                    <!-- <img src="<?php echo $url?>" height="100" width="100" alt="image not found!!"> -->
                    <div style="background: red; width: 100px; height: 100px; border-radius: 50px; background: url('<?php echo $url; ?>'); background-size: cover; margin: 25px 25px;">&nbsp;</div>
                </div>
                <div class="user-detail" style="padding-bottom: 20px;">
                    <p style='font-weight: bold; text-transform: capitalize'><?php echo $user["username"] ?></p>
                    <p><?php echo $user["designation"] ?? "[No designation yet]" ?></p>
                    <p><?php echo $user["slogan"] ?? "[No motto yet]"; ?></p>
                </div>
            </div>
            <?php
            // $sql = "(SELECT P.post_data, u.username, P.post_img, P.id AS id FROM posts as P, user_friends as F, users AS u WHERE F.user_id = $id AND F.is_accepted = 1 AND F.friend_id = P.user_id AND P.user_id = u.id) UNION (SELECT P.post_data, u.username, P.post_img, P.id AS id FROM posts as P, user_friends as F, users AS u WHERE F.friend_id = $id AND F.is_accepted = 1 AND F.user_id = P.user_id AND P.user_id = u.id)";
            $sql = "SELECT posts.created_data, posts.post_data, posts.id, posts.created_data, users.username, posts.user_id, posts.post_img FROM posts INNER JOIN users ON users.id = posts.user_id HAVING posts.user_id = $id ";
            $result = mysqli_query($db, $sql);
            if($result->num_rows > 0):
        ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="post" style="padding: 10px;">
                        <div class="user-details">
                            <p>Uploaded by: <?php echo $row["username"] ?> 
                                <?php if($_SESSION["user_id"] == $row["user_id"]): ?>
                                    - 
                                    <!-- <form method="POST" style="display: inline;" name="postDelete" id="postDelete"> -->
                                        <input type="hidden" name="post_id" value="<?php echo $row["id"] ?>">
                                        <a href="controller/post_delete.php?post_id=<?php echo $row["id"] ?>"><i style="color: black; font-size: 10px;" class="fa-solid fa-trash"></i></a>
                                    <!-- </form> -->
                                    - 
                                    <a href="/social/update_post.php?post_id=<?php echo $row["id"]; ?>"><i style="font-size: 10px; color: black;" class="fa-solid fa-pen-to-square"></i></a>
                                <?php endif; ?>
                            </p>
                            <p><?php echo $row["created_data"] ?? "date feature didn't support at the time of this posting"; ?></p>
                        </div>
                        <div class="post-details">
                            <p><?php echo $row["post_data"] ?></p>
                            <?php if($row["post_img"]): ?>
                                <div class="post-image" style="overflow: hidden; text-align: center; background: url('controller/uploads/<?php echo $row["post_img"] ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;">
                                    &nbsp;
                                    <!-- <img src="controller/uploads/<?php echo $row["post_img"] ?>" style="object-fit: cover;" /> -->
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php 
                            $post_id = $row["id"];
                            $user_id = $_SESSION['user_id'];
                            $sql = "SELECT count(*) AS isLiked FROM post_likes WHERE user_id = $user_id AND post_id = $post_id";
                            $isLikedResult = mysqli_query($db, $sql);
                            $isLiked = mysqli_fetch_assoc($isLikedResult);
                            $status = 0;
                            if($isLiked['isLiked'] <= 0 ) {
                                $status = 0;
                            } else {
                                $status = 1;
                            }
                        ?>
                        <div class="post-btn" style="display: flex; justify-content: space-between;">
                            <button style="width: 32.7%">Share</button>
                            <button 
                                style="width: 32.7%" 
                                class="like-button <?php if($status): ?>liked <?php endif; ?>" 
                                data-status="<?php echo $status ?>" 
                                data-post="<?php echo $row["id"] ?>">
                                Like
                            </button>
                            <button style="width: 32.7%">Comment</button>
                        </div>
                        <div class="additional-details">
                            <?php 
                                $sql = "SELECT count(*) AS count FROM post_likes WHERE post_id = $post_id";
                                $countResult = mysqli_query($db, $sql);
                                $count = mysqli_fetch_assoc($countResult);
                            ?>
                            <p class="likes" id="like-id-<?php echo $row["id"]; ?>" data-id="<?php echo $row["id"] ?>">
                                <?php if($count["count"] <= 0): ?>
                                    No likes
                                <?php else: ?>
                                    <?php echo $count["count"] ?> likes
                                <?php endif; ?>
                            </p>
                            <?php 
                                $sql = "SELECT count(*) AS comment_count FROM comments WHERE post_id = $post_id";
                                $countCommentResult = mysqli_query($db, $sql);
                                $commentQty = mysqli_fetch_assoc($countCommentResult);
                            ?>
                            <p class="show-comments" data-id="<?php echo $row["id"] ?>"><?php echo $commentQty["comment_count"] ?> Comments</p>
                        </div>
                        <div class="comment none" style="display: none;" data-id="<?php echo $row["id"] ?>">
                        <div class="user-comment" data-id="<?php echo $row["id"]; ?>">
                            <?php 
                                // $sql = "SELECT * FROM `comments` AS c, `users` AS u WHERE c.post_id = $post_id AND c.user_id = u.id AND c.comment_id IS NULL";
                                $sql = "SELECT * FROM comments INNER JOIN users ON users.id = comments.user_id HAVING comments.post_id = $post_id";
                                $commentResult = mysqli_query($db, $sql);
                                while($commentRows = mysqli_fetch_assoc($commentResult)):
                            ?>  
                                <div class="comment-writer">
                                    <p><?php echo $commentRows["username"] ?></p>
                                </div>
                                <div class="comment-material" style="margin-bottom: 10px;">
                                    <p><?php echo $commentRows["comment"] ?></p>
                                </div>
                            <?php endwhile; ?>
                                </div>
                                <?php 
                                $sql = "SELECT username FROM users WHERE id = $user_id";
                                $userResult = mysqli_query($db, $sql);
                                $loggedInUser = mysqli_fetch_assoc($userResult);
                            ?>
                            <form method="POST" name="addComment" class="addComment">
                                <div class="add-comment" data-id="<?php echo $row["id"] ?>">
                                    <input type="text" id="insert-comment" name="comment" placeholder="Comment">
                                    <input type="hidden" id="insert-user" name="user_id" value="<?php echo $_SESSION["user_id"] ?>"/>
                                    <input type="hidden" id="insert-post" name="post_id" value="<?php echo $row["id"] ?>"/>
                                    <input type="hidden" id="name" name="name" value="<?php echo $loggedInUser["username"]; ?>" />
                                </div>
                            </form>
                        </div>
                        <?php if(!$count["count"] <= 0): ?>
                            <div class="liked-persons" data-id="<?php echo $row["id"] ?>">
                                <ul>
                                    <?php 
                                        $sql = "SELECT DISTINCT u.username FROM posts AS p, post_likes AS pl, users AS u WHERE pl.user_id = u.id AND pl.post_id = $post_id";
                                        $user_likes = mysqli_query($db, $sql);
                                        while($rows = mysqli_fetch_assoc($user_likes)):
                                    ?>
                                        <li><?php echo $rows["username"]; ?></li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
                <?php else: ?>
                    <div style="background: red; width: 100%; color: white; padding: 5px 10px 5px 10px; border-radius: 10px;">
                    <p style="text-align: center;">
                        You have not uploaded any posts
                    </p>
                </div>
                <?php endif; ?>
            </div>
            <footer>
                <div class="wrappe">
                    <p>Copyrights reserved to the FakeBook</p>
                </div>
            </footer>
            
            <script>

const commentForms = document.querySelectorAll(".addComment");
        commentForms.forEach(form => {
            form.addEventListener("submit", e => {
                e.preventDefault();
                const inputCollections = form.childNodes[1];
                console.log(inputCollections.childNodes);
                const comment = inputCollections.childNodes[1];
                const user_id = inputCollections.childNodes[3];
                const post_id = inputCollections.childNodes[5];
                const username =inputCollections.childNodes[7];

                const commentForm = new FormData();
                commentForm.append("comment", comment.value);
                commentForm.append("user_id", user_id.value);
                commentForm.append("post_id", post_id.value);

                axios.post("controller/add_comment.php", commentForm)
                .then(res => {
                    console.log("lol");
                    // console.log(user_id);
                    const commentSection = document.querySelector(`.show-comments[data-id='${post_id.value}']`);
                    commentSection.textContent = res.data + " Comments";
                    const userComments = document.querySelector(`.user-comment[data-id='${post_id.value}']`);
                    userComments.innerHTML += `<div class="comment-writer"><p>${username.value}</p></div>`;
                    userComments.innerHTML += `<div class='comment-material' style="margin-bottom: 10px;"><p>${comment.value}</p></div>`;
                    comment.value = "";
                })
                .catch(err => {

                })
            })
        })
            </script>

            <script>
        const comments = document.querySelectorAll(".like-button");
        comments.forEach(comment => {
            comment.addEventListener("click", function() {
                let params = new URLSearchParams();
                params.append("post_id", comment.dataset.post);
                params.append("status", comment.dataset.status);
                axios.post("controller/like_post.php", params)
                .then(function(response) {
                    
                    const likesElement = document.getElementById(`like-id-${response.data.post_id}`);
                    let likes = "No";
                    if(response.data.liked != "0") {
                        likes = response.data.liked;
                    }
                    likesElement.textContent = likes + " likes";
                    if(comment.dataset.status == "1") {
                    comment.dataset.status = "0";
                    comment.classList.remove("liked");
                    // HTMLFormControlsCollection
                    } else {
                        comment.classList.add("liked");
                        comment.dataset.status = "1";
                    }
                })
                .catch(function(err) {
                    console.log(err)
                })
            })
        })
    </script>
        <script src="js/fnc.js"></script>
        <!-- <script src="js/Components/post.js"></script> -->
        <script src="js/mode.js"></script>
</body>

</html>