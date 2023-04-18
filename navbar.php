<?php

$options = '';

if(!isset($_SESSION["user_name"])) {
    $options = "
        <ul class=\"navbar-nav mr-auto\">
            <li class=\"nav-item\">
                <a class=\"nav-link\" href=\".\index.php\">Home</a>
            </li>
            <li class=\"nav-item\">
                <a class=\"nav-link\" href=\".\login.php\">Login</a>
            </li>
            <li class=\"nav-item\">
                <a class=\"nav-link\" href=\".\signup.php\">Sign Up</a>
            </li>
        </ul>
    ";
} else {
    $options = "
        <ul class=\"navbar-nav mr-auto\">
            <li class=\"nav-item\">
                <a class=\"nav-link\" href=\".\index.php\">Home</a>
            </li>
            <li class=\"nav-item\">
                <a class=\"nav-link\" href=\".\Feed.php\">Feed</a>
            </li>
            <li class=\"nav-item\">
                <a class=\"nav-link\" href=\".\logout.php\">Log Out</a>
            </li>
        </ul>
        <a href=\".\Template.php\"> <i class=\"fa-regular fa-user fa-xl\" style=\"color: white\"></i> </a>
    ";
}

?>

<!DOCTYPE html>
<html lang="en">

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="index.php">FitNation</a>
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarCollapse"
        aria-controls="navbarCollapse"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <?php
            echo $options;
        ?>
    </div>
</nav>