<?php
session_start();
include("db_connection.php");
include("auth.php");
// $timeout = 1800;
// ini_set("session.gc_maxlifetime", $timeout);
// ini_set("session.cookie_lifetime", $timeout);

if (check_login()) {
    header("location:feed.php");
}

if (isset($_POST["Sign_Up"])) {
    if(empty($_POST["Username"]) || empty($_POST["Password"]) || empty($_POST["Email"] || empty($_POST["DOB"]))) {
        function_alert("You must input something in to the \"Username\", \"Password\", \"Email\", and \"Date of Birth\" fields.");
    } else {
        $char = "/[a-zA-Z]/";
        $num = "/[0-9]/";
        $symbol = "/[~`!@#\$%^&*_:;\",.?\/]/";
        $not_allowed_symbol = "/[<>[]\\'()\+-={}]/";
        if (strlen($_POST["Password"]) > 7 && preg_match($char, $_POST["Password"]) 
            && preg_match($num, $_POST["Password"]) && preg_match($symbol, $_POST["Password"])
            && !preg_match($not_allowed_symbol, $_POST["Password"])) {
            // Check if the email and username are unique
            $check_unique = "SELECT * FROM user WHERE Email = ? OR Username = ?";
            $check_stmt = $conn->prepare($check_unique);
            // Bind the parameters
            $check_stmt->bindParam(1, $_POST["Email"], PDO::PARAM_STR);
            $check_stmt->bindParam(2, $_POST["Username"], PDO::PARAM_STR);
            $check_stmt->execute();

            // Check if the query returned any rows meaning the email or username already exists
            if ($check_stmt->rowCount() > 0) {
                function_alert("Email or Username already exists. Please try again.");
            } else {
                // Hash the password
                $hashed_password = password_hash($_POST["Password"], PASSWORD_DEFAULT);
                $sql = "INSERT INTO user (Email, Password, Username, Date_Joined, DOB) VALUES (?, ?, ?, CURDATE(), ?)";
            
                // Prepare the SQL statement
                $stmt = $conn->prepare($sql);
        
                // Bind the parameters
                $stmt->bindParam(1, $_POST["Email"], PDO::PARAM_STR);
                $stmt->bindParam(2, $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(3, $_POST["Username"], PDO::PARAM_STR);
                $stmt->bindParam(4, $_POST["DOB"]);
        
                // Execute the SQL statement
                if ($stmt->execute()) {
                    $user_id = $conn->lastInsertId();
                    function_alert("User successfully created!");
                    $_SESSION["user_name"] = $_POST["Username"];
                    $_SESSION["active"] = 1;
                    $_SESSION['user_id'] = $user_id;
                    // setcookie("user_name", $row['Username'], time()+3600, '/');
                    // setcookie("active", 1, time()+3600, '/');
                    echo "<script>window.location.href='feed.php';</script>";
                }
            }
        } else {
            function_alert("Password doesn't meet the requirements. Please type a password that meets them and try again.");
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
    <meta charset="utf-8">
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >
    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    >
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- google fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anton">
    <link rel="stylesheet" href="css/signup.css">
    <!-- Icon script -->
    <script src="https://kit.fontawesome.com/2b70e8a21a.js" crossorigin="anonymous"></script>
    <!-- Website Icon -->
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico">
    <title>Sign Up For FitNation</title>

</head>

<body>
    <header>
        <?php
            include("navbar.php");
        ?>
    </header>
    <main>
        <div class="img_container">
            <img src="Images/Purple-Logo.png" alt="FitNation Logo with Purple Background">
        </div>
        <div class="container">
            <form id="signup_form" method="post" onsubmit="return submitPasswordValid();">
                <div class="form-group">
                    <label for="Username">Username</label>
                    <input type="text" name="Username" id="Username" class="form-control">
                </div>
                <div class="form-group password-container">
                    <label for="Password">Password</label>
                    <input type="password" name="Password" id="Password" class="form-control">
                    <i class="fa-solid fa-eye" id="eye"></i>
                    <div id="password_message">
                        <ul style="list-style-type: none">
                            <li id="password_letter">Password contains at least <b>one letter</b>.</li>
                            <li id="password_number">Password contains at least <b>one number</b>.</li>
                            <li id="password_symbol">Password contains at least <b>one symbol</b>.<br>Allowed Symbols: ~`!@#$%^&*_:;",.?/<br>Not Allowed Symbols: &lt;&gt;[]'()\+-={}</li>
                            <li id="password_length">Password must be at least <b>7 characters</b> in length.</li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" name="Email" id="Email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="DOB">Date of Birth</label>
                    <input type="date" name="DOB" id="DOB" class="form-control">

                </div>
                <div class="form-group text-center">
                    <input type="submit" name="Sign Up" id="Sign_Up" value="Sign Up" class="btn btn-lg btn-primary">
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
    <script>
    // Javascript based off of: https://medium.com/@mignunez/html-css-javascript-how-to-show-hide-password-using-the-eye-icon-27f033bf84ad#:~:text=JavaScript%3A,them%20each%20in%20a%20variable.&text=Now%20add%20a%20click%20event,input%20field%20is%20currently%20displaying.
    let password_input = document.querySelector("#Password");
    let eye_icon = document.querySelector("#eye");
    eye_icon.addEventListener("click", function(){
        this.classList.toggle("fa-eye-slash");
        if (this.classList.contains("fa-eye")) {
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash");
        } else {
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye");
        }
        const type = password_input.getAttribute("type") === "password" ? "text" : "password";
        password_input.setAttribute("type", type);
    });
    </script>
    <!-- Password verifier 
        Verifies that the password entered meets certain requirements.
    -->
    <script src=".\script\signup.js"></script>
</body>
</html>