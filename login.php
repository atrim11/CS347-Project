<?php 
session_start();
include("db_connection.php");
include("auth.php");

// $timeout = 1800;
// ini_set("session.gc_maxlifetime", $timeout);
// ini_set("session.cookie_lifetime", $timeout);


if(check_login())
{
 header("location:feed.php");
}

$msg = '';

if(isset($_POST["login"]))
{
 if(empty($_POST["user_email"]) || empty($_POST["user_password"]))
 {
  $msg = "<div class='alert alert-danger'>Both Fields are required</div>";
 }
 else
 {
  $query = "
  SELECT * FROM user
  WHERE Email = :user_email
  ";
  $stmt = $conn->prepare($query);
  $stmt->execute(
   array(
    'user_email' => $_POST["user_email"]
   )
  );

  $count = $stmt->rowCount();

  if($count == 0) {
    $msg = '<div class="alert alert-danger">Account With Email Does Not Exist</div>';
  } else {
    $result = $stmt->fetchAll();
    foreach($result as $row) {
      if (password_verify($_POST['user_password'], $row['Password'])) {
        // Sets timeout to expire in 1 hour
        $time = time()+3600;
        if (isset($_POST["remember-me"])) {
          // Sets timeout to expire January 9, 2038
          $time = 2147483647;
        }

        // $_SESSION['logged'] = 1;
        $_SESSION['user_name'] = $row['Username'];
        $_Session['first_name'] = $row['F_Name'];
        $_Session['last_name'] = $row['L_Name'];
        $_SESSION['date_joined'] = $row['Date_Joined'];
        $_SESSION['active'] = 1;
        $_SESSION['user_id'] = $row['user_id'];
        setcookie("user_name", $row['Username'], $time, '/');
        setcookie("active", 1, $time, '/');
        
        // $_COOKIE['user_name'] = $_POST["Username"];
        echo "<script>window.location.href='feed.php';</script>";
      } else {
        $msg = '<div class="alert alert-danger">Wrong Password</div>';
      }
    }
  }
  
 }
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
    <!-- Icon script -->
    <script src="https://kit.fontawesome.com/2b70e8a21a.js" crossorigin="anonymous"></script>
    <!-- google fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anton">
    <style>
        .navbar-brand {
            font-family: 'Anton', sans-serif;
        } 
    </style>
    <script src="https://kit.fontawesome.com/2b70e8a21a.js" crossorigin="anonymous"></script>
    <!-- Website Icon -->
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico">
    <title>FitNation Login</title>
    <style>
        main {
            display: flex;
            align-items: center;
            flex-direction: column;
        }
        .img_container {
            max-width: 900px;
            overflow: hidden;
        }
        img {
            width: 100%;
            object-fit: contain;
        }
        /* Add a hover effect for buttons */
        button:hover {
            opacity: 0.8;
        }
        .checkbox {
          float: right;
        }

        /* Styling from: https://medium.com/@mignunez/html-css-javascript-how-to-show-hide-password-using-the-eye-icon-27f033bf84ad#:~:text=JavaScript%3A,them%20each%20in%20a%20variable.&text=Now%20add%20a%20click%20event,input%20field%20is%20currently%20displaying. */
        .password-container{
          position: relative;
        }
        .fa-eye, .fa-eye-slash{
          position: absolute;
          top: 61%;
          right: 7%;
          cursor: pointer;
          color: lightgray;
        }

    </style>
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
            <div class="panel panel-default">         
             <div class="panel-heading">Login</div>
             <div class="panel-body">
              <span><?php echo $msg; ?></span>

              <form method="post">

                <div class="form-group">
                  <label for="user_email">User Email</label>
                  <input type="text" name="user_email" id="user_email" class="form-control">
                </div>

                <div class="form-group password-container">
                  <label for="user_password">Password</label>
                  <input type="password" name="user_password" id="user_password" class="form-control">
                  <i class="fa-solid fa-eye" id="eye"></i>
                </div>

                <div class="form-group">
                  <a href="#">Forgot Password?</a>
                </div>

                <div class="form-group">
                  <label class="checkbox">
                  <input type="checkbox" name="remember-me" value="remember-me" id="remember-me"> Remember Me
                  </label>
                </div>

                <div class="form-group text-center">
                  <input type="submit" name="login" id="login" class="btn btn-lg btn-primary" value="Login">
                </div>
               
              </form>
             </div>
            </div>
          </div>
    </main>
<script>
  // Javascript based off of: https://medium.com/@mignunez/html-css-javascript-how-to-show-hide-password-using-the-eye-icon-27f033bf84ad#:~:text=JavaScript%3A,them%20each%20in%20a%20variable.&text=Now%20add%20a%20click%20event,input%20field%20is%20currently%20displaying.
  let password_input = document.querySelector("#user_password");
  let eye_icon = document.querySelector("#eye");
  eye_icon.addEventListener("click", function(){
    // this.classList.toggle("fa-eye-slash");
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