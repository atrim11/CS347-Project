<?php
include("db_connection.php");


if (isset($_POST["Sign Up"])) {
    if(empty($_POST["Username"]) || empty($_POST["Password"]) || empty($_POST["Email"]) || empty($_POST["Phone_Num"])) {
        function_alert("You must input something in to the \"Username\", \"Password\", \"Email\" and \"Phone Number\" fields.");
    }
    else {
        $sql = "INSERT INTO user (Email, Phone_Num, Password, Username, F_Name, 
        L_Name, Date_Joined, DOB, Gender) VALUES (:Email, :Phone_Num, :Password, 
        :Username, :F_Name, :L_Name, :Date_Joined, :DOB, :Gender";
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
                    <label>First Name</label>
                    <input type="text" name="F_Name" id="F_Name" class="form-control">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="L_Name" id="L_Name" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Email" id="Email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="Phone_Num" id="Phone_Num" class="form-control">
                </div>
                <div class="form-group">
                    <label>Date Of Birth</label>
                    <input type="date" name="DOB" id="DOB" class="form-control">
                </div>
                <div class="form-group">
                    <label>Gender</label><br>

                    <input type="radio" name="Gender" id="Male" value="Male">
                    <label for="Male">Male</label><br>

                    <input type="radio" name="Gender" id="Female" value="Female">
                    <label for="Female">Female</label><br>

                    <input type="radio" name="Gender" id="Other" value="Other">
                    <label for="Other">Other</label><br>
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