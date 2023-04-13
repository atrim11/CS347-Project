<?php
include("db_connection.php");

if (isset($_COOKIE["user_name"])) {
    header("location:feed.php");
}

if (isset($_POST["Sign_Up"])) {
    if(empty($_POST["Username"]) || empty($_POST["Password"]) || empty($_POST["Email"])) {
        function_alert("You must input something in to the \"Username\", \"Password\", \"Email\" fields.");
    } else {
        // Check if the email and username are unique
        $check_unique = "SELECT * FROM user WHERE Email = :Email OR Username = :Username";
        $check_stmt = $conn->prepare($check_unique);
        // Bind the parameters
        $check_stmt->bindParam(':Email', $_POST["Email"]);
        $check_stmt->bindParam(':Username', $_POST["Username"]);
        $check_stmt->execute();

        // Check if the query returned any rows meaning the email or username already exists
        if ($check_stmt->rowCount() > 0) {
            function_alert("Email or Username already exists. Please try again.");
        } else {
            // Hash the password
            $hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (Email, Password, Username, Date_Joined) VALUES (:Email, :Password, :Username, CURDATE())";
        
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
    
            // Bind the parameters
            $stmt->bindParam(':Email', $_POST["Email"]);
            $stmt->bindParam(':Password', $hashed_password);
            $stmt->bindParam(':Username', $_POST["Username"]);
    
            // Execute the SQL statement
            if ($stmt->execute()) {
                function_alert("User successfully created!");
                setcookie("user_name", $_POST["Username"], time()+3600);
                header("location:feed.php");
            }
        }

    }
}

function function_alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous"
    >
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico">
    <title>Sign Up For FitNation</title>

</head>
<style>
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    input[type="date"] {
        max-width: 250px;
    }
</style>

<body>
    <header>
        <?php
            include("navbar.php");
        ?>
    </header>
    <main role="main">
        <img src="Images/Cyan-Logo.png" alt="FitNation Logo with Cyan Background">
        <div class="container">

            <form method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="Username" id="Username" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="Password" id="Password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Email" id="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="Sign Up" id="Sign Up" value="Sign Up" class="btn btn-lg btn-primary">
                </div>
            </form>
        </div>
    </main>

    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
</body>
</html>