<?php session_start(); ?>
    <?php include_once("partials/header.php") ?>
    <?php require_once("config/connection.php"); ?>
        <div class="user-list">
            <ul>
                <li>
                    <form style="display: flex; justify-content: space-between;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" name="searchUser" id="searchUser">
                        <input type="text" name="search" id="search" value="<?php echo $_GET['search'] ?? ""; ?>" placeholder="Search friends..." style="width: 90%;">
                        <input type="submit" value="Search" style="width: 8%"/>
                    </form>   
                 </li>
                <?php 
                    $user_id = $_SESSION['user_id'];
                    // $sql = "SELECT * FROM users WHERE id != '$user_id'";
                    $subCondition = "";
                    if(isset($_GET['search'])) {
                        $keyword = $_GET['search'];
                        $subCondition = " AND users.username LIKE '%$keyword%'";
                    }
                    $sql = "(SELECT * FROM user_friends INNER JOIN users ON user_friends.friend_id = users.id HAVING user_id = $user_id AND is_accepted = 1 $subCondition) UNION ( SELECT * FROM user_friends INNER JOIN users ON user_friends.user_id = users.id HAVING friend_id = $user_id AND is_accepted = 1 $subCondition)"; 
                    $userRows = mysqli_query($db, $sql);
                    if($userRows->num_rows > 0):
                    while($row = mysqli_fetch_assoc($userRows)):
                ?>
                    <li>
                        <div class="user" id="user-<?php echo $row['id'] ?>">
                            <h1><a href="/social/user-info.php?user=<?php echo $row["id"] ?>" class="user-link"><?php echo $row["username"] ?></a></h1>
                            <ul style="padding-left: 0px;" class="additional Details">
                                <li>Designation: <?php echo $row["designation"] ?? "Not specified yet" ?></li>
                            </ul>
                            <?php 
                                $user_id = $_SESSION["user_id"];
                                $friend_id = $row["id"];
                                $sql = "SELECT id, count(*) AS is_friend, is_accepted FROM user_friends WHERE (user_id = '$user_id' AND friend_id = '$friend_id') OR (user_id = '$friend_id' AND friend_id = '$user_id')";
                                $count = mysqli_query($db, $sql);
                                $countResult = mysqli_fetch_assoc($count);
                                if($countResult["is_friend"] < 1):
                            ?>
                                <button class="send-request" data-id='<?php echo $friend_id; ?>' style="cursor: pointer;">Send Request</button>
                            <?php elseif($countResult["is_accepted"] == "1"): ?>
                                <div style="display: flex;">
                                    <p style="margin-right: 10px; background: black; color: white; width: 50%; text-align:center; margin-top: 10px; padding: 2px 2px; border-radius: 10px;">Friends</p>
                                    <form method="POST" action="controller/unfriend.php" name="unfriend" style="width: 50%;">    
                                        <input type="hidden" name="friend_id" value="<?php echo $row["id"]; ?>"/>
                                        <button style="width: 100%;" type="submit" style="background: white; color: black; border: 1px solid black; width: 50%; text-align:center; margin-top: 10px; padding: 2px 2px; border-radius: 10px;">Unfriend</button>
                                    </form>
                                </div>  
                            <?php else: ?>
                                <p style="background: black; color: white; width: 100%; text-align:center; margin-top: 10px; padding: 2px 2px; border-radius: 10px;">Pending request</p>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endwhile; ?>
                <?php else: ?>
                    <div style="margin-top: 10px; background: red; width: 100%; color: white; padding: 5px 10px 5px 10px; border-radius: 10px;">
                        <p style="text-align: center;">
                            No friend found!
                        </p>
                    </div>
                <?php endif; ?>
            </ul>
        </div>
        <script>
            const send_request = friend_id => {
                const url = new URLSearchParams();
                url.append("user_id", <?php echo $_SESSION['user_id'] ?>);
                url.append("friend_id", friend_id);
            
                axios.post('controller/send_request.php', url)
                .then(response => {
                    const status = response.data;
                    if(status == '1') {
                        const user = document.getElementById(`user-${friend_id}`);
                        user.removeChild(user.lastElementChild);
                        user.innerHTML += '<p style="background: black; color: white; width: 100%; text-align:center; margin-top: 10px; padding: 2px 2px; border-radius: 10px;">Pending request</p>'
                    }
                })
                .then(err => {
                    console.log();
                })
            }

            const buttons = document.querySelectorAll(".send-request");
            buttons.forEach(button => {
                button.addEventListener("click", () => {
                    const id = button.dataset.id;
                    send_request(id);
                })
            })
            
        </script>
<?php include_once("partials/footer.php") ?>