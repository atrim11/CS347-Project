<?php 
include("db_connection.php");

if(isset($_COOKIE["u_f_name"]))
{
 header("location:feed.php");
}

$message = '';

if(isset($_POST["login"]))
{
 if(empty($_POST["user_email"]) || empty($_POST["user_password"]))
 {
  $message = "<div class='alert alert-danger'>Both Fields are required</div>";
 }
 else
 {
  $query = "
  SELECT * FROM user
  WHERE Email = :user_email
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    'user_email' => $_POST["user_email"]
   )
  );

  $count = $statement->rowCount();

  if($count == 0) {
    $message = '<div class="alert alert-danger">Account With Email Does Not Exist</div>';
  } else {
    $result = $statement->fetchAll();
    foreach($result as $row) {
      if ($_POST['user_password'] == $row['Password']){ // if (password_verify($_POST['user_password'], $row['Password'])) {
        setcookie("u_f_name", $row['F_Name'], time()+3600);
        header("location:feed.php");
      } else {
        $message = '<div class="alert alert-danger">Wrong Password</div>';
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
                <a class="nav-link" href=".\login.html">Login <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Sign Up</a>
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
              <span><?php echo $message; ?></span>

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
</html>