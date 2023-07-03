    <?php include_once("partials/header.php") ?>
    <section id="login" class="parent">
    <?php if(isset($_SESSION["error"])): ?>
        <div style="position: fixed; bottom: 10px; background: red; width: 50%; color: white; padding: 5px 10px 5px 10px; border-radius: 10px;">
                    <p style="text-align: center;">
                        <?php echo $_SESSION["error"]; ?>
                    </p>
                </div>
    <?php 
    endif;
    unset($_SESSION["error"]); 
    ?>
        <div style="background-color: lightblue; border-radius:50px ; padding: 50px;" class="log-in wrapper">
            
            <form action="controller/login.php" method="POST" name="userLogin" id="userLogin" class="form">
                
                <h1>Login</h1>
                <label for="text">
                    <p>Username</p>
                    <input type="text" name="username" id="text" required>
                </label>
                <label for="password">
                    <p>Password</p>
                    <input type="password" name="password" id="password" required>
                </label>
                <label>
                    <input style="background-color : white ; border-radius: 20px ; color: black; margin: auto; width: 350px;" type="submit" value="Login"  class="loginBtn">
                </label>
            </form>
        </div>
    </section>
    
    <script src="js/fnc.js"></script>
    <script src="js/mode.js"></script>
</body>
</html>