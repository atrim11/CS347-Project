<?php
session_start();
include("db_connection.php");
// $timeout = 1800;
// ini_set("session.gc_maxlifetime", $timeout);
// ini_set("session.cookie_lifetime", $timeout);

if (isset($_SESSION["user_name"])) {
    header("location:feed.php");
}

if (isset($_POST["Sign_Up"]) && $_POST["Sign_Up"] == TRUE) {
    if(empty($_POST["Username"]) || empty($_POST["Password"]) || empty($_POST["Email"])) {
        function_alert("You must input something in to the \"Username\", \"Password\", \"Email\" fields.");
    } else {
        // Check if the email and username are unique
        $check_unique = "SELECT * FROM user WHERE Email = ? OR Username = ?";
        $check_stmt = $conn->prepare($check_unique);
        // Bind the parameters
        // $check_stmt->bindParam(':Email', $_POST["Email"]);
        // $check_stmt->bindParam(':Username', $_POST["Username"]);
        // $check_stmt->bindParam('ss', $_POST["Email"], $_POST["Username"]);
        $check_stmt->bindParam(1, $_POST["Email"], PDO::PARAM_STR);
        $check_stmt->bindParam(2, $_POST["Username"], PDO::PARAM_STR);
        $check_stmt->execute();

        // Check if the query returned any rows meaning the email or username already exists
        if ($check_stmt->rowCount() > 0) {
            function_alert("Email or Username already exists. Please try again.");
        } else {
            // Hash the password
            $hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (Email, Password, Username, Date_Joined) VALUES (?, ?, ?, CURDATE())";
        
            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
    
            // Bind the parameters
            // $stmt->bindParam(':Email', $_POST["Email"]);
            // $stmt->bindParam(':Password', $hashed_password);
            // $stmt->bindParam(':Username', $_POST["Username"]);
            $stmt->bindParam(1, $_POST["Email"], PDO::PARAM_STR);
            $stmt->bindParam(2, $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(3, $_POST["Username"], PDO::PARAM_STR);
    
            // Execute the SQL statement
            if ($stmt->execute()) {
                function_alert("User successfully created!");
                $_SESSION["user_name"] = $_POST["Username"];
                $_SESSION["active"] = 1;
                //setcookie("user_name", $_POST["Username"], time()+3600);
                echo "<script>window.location.href='feed.php';</script>";
                //header("location:feed.php");
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
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- google fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anton">
    <style>
        .navbar-brand {
            font-family: 'Anton', sans-serif;
        } 
    </style>
    <!-- Icon script -->
    <script src="https://kit.fontawesome.com/2b70e8a21a.js" crossorigin="anonymous"></script>
    <!-- Website Icon -->
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico">
    <title>Sign Up For FitNation</title>

</head>
<style>
    img {
        width: 100%;
    }

    .valid {
        color: green;
        background-color: rgba(36, 207, 147, 0.1);
    }

    .invalid {
        color: red;
        background-color: rgba(255, 49, 101, 0.1);
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
            <form id="signup_form" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="Username" id="Username" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="Password" id="Password" class="form-control">
                    <span id="password_message">
                        <ul style="list-style-type: none">
                            <li id="password_letter">Password contains at least <b>one letter</b>.</li>
                            <li id="password_number">Password contains at least <b>one number</b>.</li>
                            <li id="password_symbol">Password contains at least <b>one symbol</b>.<br>Allowed Symbols: ~`!@#$%^&*_:;",.?/</li>
                            <li id="password_length">Password must be at least <b>7 characters</b> in length.</li>
                        </ul>
                    </span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Email" id="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" name="Sign Up" id="Sign Up" value="Sign Up" onsubmit="return submitPasswordValid();" class="btn btn-lg btn-primary">
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
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <!-- Password verifier 
        Verifies that the password entered meets certain requirements.
    -->
    <script type="text/javascript">
        var password = document.getElementById("Password");
        password.oninput = function verifyPassword() {

            var letter = document.getElementById("password_letter");
            var number = document.getElementById("password_number");
            var symbol = document.getElementById("password_symbol");
            var length = document.getElementById("password_length");

            var invalid = "&#x274C";
            var valid = "&#x2713;";

            var accepted_letters = /[a-zA-Z]/g;
            if (password.value.match(accepted_letters)) {
                letter.innerHTML = `${valid} Password contains at least <b>one letter</b>.`;
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.innerHTML = `${invalid} Password contains at least <b>one letter</b>.`;
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }

            var accepted_numbers = /[1-9]/g;
            if (password.value.match(accepted_numbers)) {
                number.innerHTML = `${valid} Password contains at least <b>one number</b>.`;
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.innerHTML = `${invalid} Password contains at least <b>one number</b>.`;
                number.classList.remove("valid");
                number.classList.add("invalid");
            }

            var accepted_symbols = /[~`!@#\$%\^&\*_:;",.\?\/]/g;
            if (password.value.match(accepted_symbols)) {
                symbol.innerHTML = `${valid} Password contains at least <b>one symbol</b>.<br>Allowed Symbols: ~\`!@#$%^&*_:;",.?/`;
                symbol.classList.remove("invalid");
                symbol.classList.add("valid");
            } else {
                symbol.innerHTML = `${invalid} Password contains at least <b>one symbol</b>.<br>Allowed Symbols: ~\`!@#$%^&*_:;",.?/`;
                symbol.classList.remove("valid");
                symbol.classList.add("invalid");
            }

            if (password.value.length > 7) {
                length.innerHTML = `${valid} Password must be at least <b>7 characters</b> in length.`;
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.innerHTML = `${invalid} Password must be at least <b>7 characters</b> in length.`;
                length.classList.remove("valid");
                length.classList.add("invalid");
            }
        }

        // function submitPasswordValid () {
        //     var letter = document.getElementById("password_letter");
        //     var number = document.getElementById("password_number");
        //     var symbol = document.getElementById("password_symbol");
        //     var length = document.getElementById("password_length");

        //     return letter.classList.contains("valid") && number.classList.contains("valid") &&
        //         symbol.classList.contains("valid") && length.classList.contains("valid");
        // }

    </script>
</body>
</html>