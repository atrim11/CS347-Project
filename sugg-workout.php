<?php
// $timeout = 1800;
// ini_set("session.gc_maxlifetime", $timeout);
// ini_set("session.cookie_lifetime", $timeout);

session_start();
include("auth.php");
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
    <title>FitNation</title>
</head>
<body>
    <header>
        <?php
        include("navbar.php");
        ?>
    </header>
    <main>
    <div class="container">
      <div class="row ">
        <div class="col-lg-4">
        </div>
        <div class="btn-group">
          <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Arms
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" id="triceps">triceps</a>
            <a class="dropdown-item" id="biceps">biceps</a>
            <a class="dropdown-item" id="forearms">forearms</a>
          </div>
        </div>
        <div class="btn-group">
          <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Torso
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" id="chest">chest</a>
            <a class="dropdown-item" id="lats">lats</a>
            <a class="dropdown-item" id="abdominals">abdominals</a>
            <a class="dropdown-item" id="middleback">middle Back</a>
            <a class="dropdown-item" id="lowerback">lower Back</a>
          </div>
        </div>
        <div class="btn-group">
          <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Legs
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" id="glutes">glutes</a>
            <a class="dropdown-item" id="hamstrings">hamstrings</a>
            <a class="dropdown-item" id="quadriceps">quadriceps</a>
            <a class="dropdown-item" id="calves">calves</a>
          </div>
        </div>
      </div>
      <div id="workouts"></div>
    </div>
        <!--  JavaScript -->
    <script src="workout.js"  type="module"></script>
    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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