<?php
function check_login() {
  if (isset($_SESSION["user_name"]) && isset($_COOKIE['user_name']) && isset($_COOKIE['active'])) {
    return true;
  }
  return false;
}

if (isset($_COOKIE['user_name']) && isset($_COOKIE['active'])) {
  $_SESSION['user_name'] = $_COOKIE['user_name'];
  $_SESSION['active'] = $_COOKIE['active'];
}
?>
