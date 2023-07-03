<?php include_once("config/connection.php"); ?>
<?php 
$uri = $_SERVER["REQUEST_URI"];
$parsedURI = explode("/", $uri);

error_reporting(E_ALL ^ E_NOTICE);  
if(!($parsedURI[2] == "login.php" OR $parsedURI[2] == "register.php")) {
    require_once("config/guard.php");
    // echo "in login";
}
session_start() ;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FakeBook | Home</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://kit.fontawesome.com/3a7e8b6e65.js" crossorigin="anonymous"></script>

</head>

<body>
    <div class="wrapper">
        <header>
            <div class="logo">
                <h1><a href="/social" style="color: black; text-decoration: none;">FakeBook</a></h1>
            </div>
            <div class="top-nav">
                <nav>
                    <ul>
                        
                    <?php 
                            if(isset($_SESSION["user_id"])):
                        ?>
                        <li><a href="/social/friends.php">Friends</a></li>
                        <li><a href="/social/requests.php">Requests</a></li>
                        <li><a href="/social/user-info.php">Profile</a></li>
                        <li><a href="/social/user.php">Settings</a></li>
                        <li><a href="/social/user-list.php">User Lists</a></li>
                        <li><a href="controller/logout.php">Log out</a></li>
                        <?php else: ?>
                            <li><a href="/social/register.php">Register</a></li>
                            <li><a href="/social/login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </header>