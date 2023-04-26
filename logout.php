<?php
session_start();
include("auth.php");
if (check_login()){
    unset($_COOKIE["user_name"]);
    unset($_COOKIE["active"]);
    setcookie("user_name", "", time() - 3600, "/");
    setcookie("active", "", time() - 3600, "/");
}
// unset($_SESSION["logged"]);
unset($_SESSION["user_name"]);
unset($_SESSION["active"] );
session_destroy();
header("location:login.php");

?>