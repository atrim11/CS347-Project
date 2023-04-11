<?php 
include("db_connection.php");

if(isset($_COOKIE["user_name"]))
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
      if ($_POST['user_password'] == $row['Password']){ // if (password_verify($_POST['user_password'], $row['Password'])) {
        setcookie("user_name", $row['Username'], time()+3600);
        header("location:feed.php");
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico">
    <style>

        main {
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        } 

        img {
            position: relative;
            max-width: 100%;
            max-height: 100%;
        }
        
        /* Add a hover effect for buttons */
        button:hover {
            opacity: 0.8;
        }

    </style>
</head>
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
                <a class="nav-link" href=".\index.html"
                  >Home </a
                >
              </li>
              <li class="nav-item active">
                <a class="nav-link" href=".\login.php">Login <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href=".\signup.php">Sign Up</a>
              </li>
            </ul>
          </div>
        </nav>
    </header>

    <main role="main">
        <img src="Images/Clear-Logo.png" alt="">

        <div class="container">
            <div class="panel panel-default">         
             <div class="panel-heading">Login</div>
             <div class="panel-body">
              <span><?php echo $msg; ?></span>

              <form method="post">
               <div class="form-group">
                <label>User Email</label>
                <input type="text" name="user_email" id="user_email" class="form-control" />
               </div>
               <div class="form-group">
                <label>Password</label>
                <input type="password" name="user_password" id="user_password" class="form-control" />
               </div>
               <div class="form-group">
                <input type="submit" name="login" id="login" class="btn btn-lg btn-primary" value="Login" />
               </div>
              </form>
             </div>
            </div>
    </main>
</body>

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
</html>