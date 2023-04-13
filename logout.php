<?php
session_start();
if (isset($_COOKIE["user_name"])){
    unset($_COOKIE["user_name"]);
    unset($_COOKIE["active"]);
    setcookie("user_name", null, -1);
}
unset($_SESSION["logged"]);
unset($_SESSION["user"]);
unset($_SESSION["valid_user"] );
header("location:login.php");

?>