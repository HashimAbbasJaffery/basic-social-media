<?php

require("../config/connection.php");
session_start();
if(isset($_POST['username']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    
    $result = $db->query($sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($result->num_rows > 0) {
        $_SESSION['user_id'] = $row["id"];
        header("Location: ../index.php");
    } else {
        $_SESSION["error"] = "Invalid username or password";
        header("Location: ../login.php");
    }

    $db->close();
}
?>