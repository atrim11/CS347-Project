<?php
    session_start();
    // if (!isset($_COOKIE["user_name"])) {
    //     header("location:index.php");
    // }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"
    >
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico">
    <title>FitNation</title>
</head>
<body>
    <?php
        include("navbar.php");
        echo "we have made it here";
        if(isset($_SESSION['user_name']))
        {
          echo "the cookies are not sucking";
          echo '<h2 align="center">Welcome '.htmlspecialchars($_SESSION['user_name']).'</h2>';
        }
    ?>
</body>
</html>