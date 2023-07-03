<?php include_once("partials/header.php") ?>
        <section id="user-details">
            <div class="detail-container">
                <div class="options" style="box-shadow: 5px 10px 20px grey;">
                <?php 
                    
                    session_start(); 
                    $id = $_SESSION["user_id"]; 
                    $sql = "SELECT * FROM users WHERE id = $id";
                    $userDetail = mysqli_query($db, $sql);
                    $user = mysqli_fetch_assoc($userDetail);
                    $url = "https://placehold.co/100x100";
                    if($user["profile_img"]) {
                        $url = "profile_image/" . $user["profile_img"];
                    }
                ?>
                    <div class="user-image" id="background" style="background-image: url(<?php echo $url; ?>);">
                        <label class="image-upload-label">
                            <div class="image-overlay">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                            <input type="file" id="imageUpload" onchange="changeProfile()" class="image-upload">
                        </label>
                    </div>
                    <div class="option-lists">
                        <nav>
                            <ul>
                                <li><a class="active" href="#" id="details-opt" onclick="changeSection('details')">Edit Details</a></li>
                                <li><a href="#" id="hobbies-opt" onclick="changeSection('hobbies')">Add Hobbies</a></li>
                                <li><a href="#" id="security-opt" onclick="changeSection('security')">Security Details</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div id="all-sections" style="width: 65%;">
                    <div class="details display-none" id="details">
                        <form onsubmit="changeDetails(['designation', 'education'])">
                        <div class="work fields">
                            <div class="section">
                                <h1>Work</h1>
                                <p id="d-1"  value="Full-stack Laravel Developer"><span class="info-designation"><?php echo $user["designation"] ?? "[none]"; ?></span> <i
                                        onclick="showInput('d-1', 'Enter your work')"
                                        class="fa-solid fa-pencil">&nbsp;</i>
                                </p>
                                <input type="text" style="width: 100%; height: 25px" id="designation" value="<?php echo $user["designation"]; ?>" class="display-none"
                                    data-key="d-1">
                            </div>
                            <div class="section">
                                <h1>Education</h1>
                                <p id="d-2" value="Android app Developer"><span class="info-education"><?php echo $user["education"] ?? "[none]" ?></span><i
                                        class="fa-solid fa-pencil"
                                        onclick="showInput('d-2', 'Enter your education')">&nbsp;</i></p>
                                <input type="text" id="education" style="width: 100%; height: 25px" value="<?php echo $user["education"] ?? ""; ?>" class="display-none"
                                    data-key="d-2">
                            </div>
                            <input type="submit" />
                            </form>
                        </div>
                    </div>
                    <div class="hobbies details display-none" id="hobbies">
                        <form onsubmit="changeDetails(['hobby', 'slogan'])">
                        <div class="hobby work">
                            <div class="section">
                                <h1>Hobby</h1>
                                <p id="h-1" value="Full-stack Laravel Developer"><span class="info-hobby"><?php echo $user["hobby"] ?? "[none]" ?></span><i
                                        onclick="showInput('h-1', 'Enter your Hobby')"
                                        class="fa-solid fa-pencil">&nbsp;</i>
                                </p>
                                <input type="text" id="hobby" value="<?php echo $user["hobby"] ?? "[none]" ?>" style="width: 100%; height: 25px" class="display-none"
                                    data-key="h-1">
                            </div>
                            <div class="section">
                                <h1>Motto</h1>
                                <p id="h-2" value="Android app Developer"><span class="info-slogan"><?php echo $user["slogan"] ?? "[none]"; ?></span><i
                                        class="fa-solid fa-pencil"
                                        onclick="showInput('h-2', 'Enter your Motto')">&nbsp;</i></p>
                                <input type="text" id="slogan" value="<?php echo $user["slogan"] ?? "[none]" ?>" style="width: 100%; height: 25px" class="display-none"
                                    data-key="h-2">
                            </div>
                            <input type="submit" />
                        </div>
                    </form>
                    </div>

                    <div class="security details" id="security">
                        <form onsubmit="changeDetails(['email', 'password'])">
                        <div class="security work">
                            <div class="section">
                                <h1>Email</h1>
                                <p id="s-1" value="Full-stack Laravel Developer"><span class="info-email"><?php echo $user["email"] ?? "[none]" ?></span><i
                                        onclick="showInput('s-1', 'Update Email!')"
                                        class="fa-solid fa-pencil">&nbsp;</i>
                                </p>
                                <input type="text" id="email" style="width: 100%; height: 25px" class="display-none"
                                    data-key="s-1">
                            </div>
                            <div class="section">
                                <h1>Password</h1>
                                <p id="s-2" value="Android app Developer">*************<i
                                        class="fa-solid fa-pencil"
                                        onclick="showInput('s-2', 'Update Password!')">&nbsp;</i></p>
                                <input type="password" id="password" style="width: 100%; height: 25px" class="display-none"
                                    data-key="s-2">
                            </div>
                            <input type="submit" />
                        </div>
                        </form>
                    </div>
                </div>
                
        </section>

    </div>
    <script src="js/functions.js"></script>
    <script src="js/fnc.js"></script>
    <script src="js/mode.js"></script>
    <script>
        $(document).ready(() => {
            let status = "hidden";
            $("p[id]").click(function () {
                if (status == "hidden") {
                    let id = $(this).attr("id");
                    let el = $(`p[id="${id}"]`).attr("value");
                    $(".edit").css("display", "none");
                    status = "block";
                } else {
                    let id = $(this).attr("id");
                    let el = $(`p[id="${id}"]`).attr("value");
                    $(".edit").css('display', "block").attr("placeholder", el);
                    status = "hidden";
                }
            })
        })
    </script>
    <script>
        const changeProfile = () => {
            const form = new FormData();
            const imageUpload = document.getElementById("imageUpload");
            form.append("profile_pic", imageUpload.files[0]);
            console.log(imageUpload.files[0]);
            axios.post("controller/uploadProfile.php", form)
            .then(res => {
                const bg = document.getElementById("background");
                bg.style.backgroundImage = `url('profile_image/${res.data}')`
                console.log(res);
            })
            .catch(err => {
                console.log(err);
            })
        }
    </script>
    <script>
        const changeDetails = (columns) => {
            event.preventDefault();
            console.log(columns);
            const firstColumn = columns[0];
            const secondColumn = columns[1];
            const firstValue = document.getElementById(columns[0]).value;
            const secondValue = document.getElementById(columns[1]).value;
            const firstLabel = document.querySelector(`.info-${firstColumn}`);
            const firstLabelID =firstLabel.getAttribute("id");

            if(firstLabel)    
                firstLabel.textContent = firstValue;
            const secondLabel = document.querySelector(`.info-${secondColumn}`);
            const secondLabelID =secondLabel.getAttribute("id");
            if(secondLabel)
                secondLabel.textContent = secondValue;
            const detailForm = new FormData();
            detailForm.append("first_column", firstColumn);
            detailForm.append("second_column", secondColumn);
            detailForm.append("first_value", firstValue);
            detailForm.append("second_value", secondValue);


            axios.post("controller/changeDetails.php", detailForm)
            .then(res => {
                console.log(res);
            })
            .catch(err => {
                console.log(err);
            })
        }
    </script>
</body>

</html>