<?php session_start(); ?>
    <?php include_once("partials/header.php") ?>
    <?php require_once("config/connection.php"); ?>
        <div class="user-list">
            <ul>
                <li>
                    <form style="display: flex; justify-content: space-between;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" name="searchUser" id="searchUser">
                        <input type="text" name="search" id="search" value="<?php echo $_GET['search'] ?? ""; ?>" placeholder="Search users..." style="width: 90%;">
                        <input type="submit" value="Search" style="width: 8%"/>
                    </form>   
                 </li>
                <?php 
                    $user_id = $_SESSION['user_id'];
                    $sql = "SELECT * FROM user_friends AS f INNER JOIN users ON users.id = f.user_id HAVING f.is_accepted = 0 AND f.friend_id = '$user_id'";
                    if(isset($_GET['search'])) {
                        $keyword = $_GET['search'];
                        $sql .= " AND users.username LIKE '%$keyword%'";
                    }
                    $userRows = mysqli_query($db, $sql);
                    if($userRows->num_rows > 0):
                    while($row = mysqli_fetch_assoc($userRows)):
                ?>
                    <li>
                        <div class="user" id="user-<?php echo $row["user_id"]; ?>">
                            <h1><a href="#" class="user-link"><?php echo $row["username"] ?></a></h1>
                                <div class="request-detail" style='display: flex; justify-content: space-between'>
                                    <button class="accept" data-id='request-<?php echo $row['user_id']; ?>' style="margin-right: 5px;cursor: pointer;">Accept</button>
                                    <button class="reject" data-id='request-<?php echo $row['user_id']; ?>' style="cursor: pointer;">Reject</button>
                                </div>    
                            </div>
                    </li>
                <?php endwhile; ?>
                <?php else: ?>
                    <div style="margin-top: 10px; background: red; width: 100%; color: white; padding: 5px 10px 5px 10px; border-radius: 10px;">
                        <p style="text-align: center;">
                            No requests found!
                        </p>
                    </div>
                <?php endif; ?>
            </ul>
        </div>
        <script>
            const send_request = friend_id => {
            
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
            });

            const acceptbuttons = document.querySelectorAll('.accept');
            const rejectbuttons = document.querySelectorAll('.reject');

            
            const accept = user_id => {
                const url = new URLSearchParams();
                
                url.append("friend_id", <?php echo $_SESSION['user_id'] ?>);
                url.append("user_id", user_id);

                axios.post("controller/accept.php", url)
                .then(response => {
                    const el = document.getElementById(user_id.replace("request", "user"));
                    el.style.display = "none";
                })
                .catch(err => {

                })

            }

            const reject = user_id => {
                const url = new URLSearchParams();
                
                url.append("friend_id", <?php echo $_SESSION['user_id'] ?>);
                url.append("user_id", user_id);

                axios.post("controller/reject.php", url)
                .then(response => {
                    
                    const el = document.getElementById(user_id.replace("request", "user"));
                    el.style.display = "none";
                })
                .catch(err => {

                })

            }

            acceptbuttons.forEach(function(acceptbutton) {
                acceptbutton.addEventListener("click", () => {
                    const acceptId = acceptbutton.dataset.id;
                    accept(acceptId);
                });
            });

            rejectbuttons.forEach(function(rejectbutton) {
                rejectbutton.addEventListener("click", () => {
                    const rejectId = rejectbutton.dataset.id;
                    reject(rejectId);
                })
            })


            
        </script>
<?php include_once("partials/footer.php") ?>