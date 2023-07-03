<?php include_once("partials/header.php") ?>
    <section id="login" class="parent">
        <div class="log-in wrapper">
            <form action="controller/register.php" method="POST" name="userLogin" id="userLogin" class="form">
                <h1>Register</h1>
                <label for="text">
                    <p>Username</p>
                    <input type="text" name="username" id="text" required>
                </label>
                <label for="email">
                    <p>Email</p>
                    <input type="email" name="email" id="email" required style="margin-bottom: 10px">
                </label>
                <label for="password">
                    <p>Password</p>
                    <input type="password" name="password" id="password" required style="margin-bottom: 20px;">
                </label>
                <label>
                    <input type="submit" value="Register" style="color: black;" class="loginBtn">
                </label>
            </form>
        </div>
    </section>
    
    <script src="js/fnc.js"></script>
    <script src="js/mode.js"></script>
</body>
</html>