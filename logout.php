<?php

if (isset($_COOKIE["user_name"])){
    unset($_COOKIE["user_name"]);
    setcookie("user_name", null, -1);
}

header("location:login.php");

?>