<?php

setcookie("user_name", "", time()-3600);

header("location:login.php");

?>