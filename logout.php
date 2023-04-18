<?php
session_start();
if (isset($_COOKIE["user_name"])){
    unset($_COOKIE["user_name"]);
    unset($_COOKIE["active"]);
    setcookie("user_name", null, -1);
}
// unset($_SESSION["logged"]);
unset($_SESSION["user_name"]);
unset($_SESSION["active"] );
session_destroy();
header("location:login.php");

?>