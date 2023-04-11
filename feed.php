<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <a href="logout.php">Logout</a>
    </div>
    <?php
       if(isset($_COOKIE["u_f_name"]))
       {
        echo '<h2 align="center">Welcome '.htmlspecialchars($_COOKIE["u_f_name"]).'</h2>';
       }
    ?>
</body>
</html>