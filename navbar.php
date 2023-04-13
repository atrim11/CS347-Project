<?php

$options = '';

if(isset($_COOKIE["user_name"])) {
    $options = "
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\".\index.php\">Home</a>
        </li>
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\".\\feed.php\">Feed</a>
        </li>
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\".\logout.php\">Log Out</a>
        </li>
    ";
} else {
    $options = "
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\".\index.php\">Home</a>
        </li>
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\".\login.php\">Login</a>
        </li>
        <li class=\"nav-item\">
            <a class=\"nav-link\" href=\".\signup.php\">Sign Up</a>
        </li>
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
        <ul class="navbar-nav mr-auto">
            <!-- <li class="nav-item">
                <a class="nav-link" href=".\index.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=".\login.php">Login</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href=".\signup.php">Sign Up
                    <span class="sr-only">(current)</span>
                </a>
            </li> -->
            <?php
                echo $options;
            ?>
        </ul>
    </div>
</nav>