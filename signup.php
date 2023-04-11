<?php
include("db_connection.php");

if (isset($_POST["Sign_Up"])) {
    if(empty($_POST["Username"]) || empty($_POST["Password"]) || empty($_POST["Email"])) {
        function_alert("You must input something in to the \"Username\", \"Password\", \"Email\" fields.");
    } else {
        // Check if the email and username are unique
        $check_unique = "SELECT * FROM user WHERE Email = :Email OR Username = :Username";
        $check_stmt = $conn->prepare($check_unique);
        $check_stmt->bindParam(':Email', $_POST["Email"]);
        $check_stmt->bindParam(':Username', $_POST["Username"]);
        $check_stmt->execute();

        // Check if the query returned any rows meaning the email or username already exists
        if ($check_stmt->rowCount() > 0) {
            function_alert("Email or Username already exists. Please try again.");
        } else {
            $sql = "INSERT INTO user (Email, Password, Username) VALUES (:Email, :Password, :Username)";
        
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
    
            // Bind the parameters
            $stmt->bindParam(':Email', $_POST["Email"]);
            $stmt->bindParam(':Password', $_POST["Password"]);
            $stmt->bindParam(':Username', $_POST["Username"]);
    
            // Execute the SQL statement
            if ($stmt->execute()) {
                function_alert("User successfully created!");
            } else {
                function_alert("Error creating user. Please try again.");
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
        position: relative;
        max-width: 100vw;
        max-height: 100%;
    }

    input[type="date"] {
        max-width: 250px;
    }
</style>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="#">FitNation</a>
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
                    <li class="nav-item">
                        <a class="nav-link" href=".\index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=".\login.php">Login</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href=".\signup.php">Sign Up
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
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