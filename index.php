<?php 
session_start();
// $timeout = 1800;
// ini_set("session.gc_maxlifetime", $timeout);
// ini_set("session.cookie_lifetime", $timeout);


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
    <!-- google fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Anton">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" />
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
    <main role="main">
      <!-- this is the carosel -->
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1" class=""></li>
          <li data-target="#myCarousel" data-slide-to="2" class=""></li>
          <li data-target="#myCarousel" data-slide-to="3" class=""></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img
              class="bd-placeholder-img"
              width="100%"
              height="100%"
              object-fit="cover"
              src="Images/Purple-Logo.png"
              alt=""
              id="carousel-pic"
            />
          </div>
          <div class="carousel-item">
            <img
              class="bd-placeholder-img"
              width="100%"
              height="100%"
              object-fit="cover"
              src="Images/workout-pic3.jpg"
              alt=""
              id="carousel-pic"
            />
            <div class="container">
              <div class="carousel-caption text-left">
                <h1>FitNation</h1>
                <p>
                  Fitness is Better with Friends
                </p>
                <p>
                  <a class="btn btn-lg btn-primary" href="signup.php" role="button"
                    >Sign up today</a
                  >
                </p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img
              class="bd-placeholder-img"
              width="100%"
              height="100%"
              object-fit="cover"
              src="Images/workout-pic6.jpg"
              alt=""
              id="carousel-pic"
            />
            <!-- <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#777"></rect></svg> -->
            <div class="container">
              <div class="carousel-caption text-right">
                <h1 id="carousel-words">Join FitNation Today!</h1>
                <p id="carousel-words">
                  Workout Together, Achieve Together with FitNation
                </p>
                <p>
                  <a class="btn btn-lg btn-primary" href="signup.php" role="button"
                    >Sign Up</a
                  >
                </p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img
              class="bd-placeholder-img"
              width="100%"
              height="100%"
              object-fit="cover"
              src="Images/racket-pic.jpg"
              alt=""
              id="carousel-pic"
            />
            <div class="container">
              <div class="carousel-caption text-right">
                <h1 id="car-head">Join FitNation Today!</h1>
                <p id="car-p">
                  Track your progress, celebrate your victories, and reach your
                  fitness goals with FitNation.
                </p>
                <p>
                  <a class="btn btn-lg btn-primary" href="signup.php" role="button"
                    >Sign Up</a
                  >
                </p>
              </div>
            </div>
          </div>
        </div>
        <a
          class="carousel-control-prev"
          href="#myCarousel"
          role="button"
          data-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a
          class="carousel-control-next"
          href="#myCarousel"
          role="button"
          data-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <!-- Marketing messaging and featurettes
        ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">
        <!-- Text break-->

        <!-- START THE FEATURETTES -->

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Track Workouts</h2>
            <p class="lead">
              Track your workouts and reach your fitness goals with ease using
              FitNation's intuitive tracking system. Log your exercises, set
              goals, and monitor your progress over time, all in one place. Our
              advanced metrics and user-friendly interface make tracking your
              workouts a breeze, so you can focus on what matters most:
              achieving your fitness objectives.
            </p>
          </div>
          <div class="col-md-5">
            <img
              src="Images/workout-pic7.jpg"
              alt=""
              class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
              width="500px"
              height="500px"
              object-fit="cover"
              id="workout-pic"
            />
          </div>
        </div>

        <hr class="featurette-divider" />

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Set Goals</h2>
            <p class="lead">
              Whether you want to lose weight, build muscle, or simply improve
              your overall health, our platform allows you to set clear,
              achievable goals and track your progress towards them. With
              personalized insights and data-driven recommendations, you can
              make sure you're always on track to reach your objectives. Plus,
              our community of like-minded fitness enthusiasts is here to
              support and motivate you every step of the way. Join FitNation
              today and start crushing your fitness goals.
            </p>
          </div>
          <div class="col-md-5">
            <img
              src="Images/workout-pic8.jpg"
              alt=""
              class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
              width="550px"
              height="550px"
              object-fit="cover"
              id="workout-pic"
            />
          </div>
        </div>

        <hr class="featurette-divider" />

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">Connect with friends</h2>
            <p class="lead">
              Connecting with friends is a breeze with FitNation's social
              features. Our platform allows you to like and comment on your
              friends' workouts, providing a supportive and motivating community
              that will help keep you accountable and inspired. Share your
              progress, swap workout tips, and cheer each other on as you strive
              towards your fitness goals. With FitNation, you're never alone on
              your fitness journey. Join our community today and start
              connecting with like-minded fitness enthusiasts who will help you
              stay motivated and achieve your best
            </p>
          </div>
          <div class="col-md-5">
            <img
              src="Images/workout-pic5.jpg"
              alt=""
              class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
              width="500px"
              height="500px"
              object-fit="cover"
              id="workout-pic"
            />
          </div>
        </div>
        <!-- /END THE FEATURETTES -->

        <hr class="featurette-divider" />
        <!-- Three columns of text -->
        <div class="row">
          <div class="col-lg-4">
            <img
              src="Images/dude2.jpg"
              alt=""
              class="bd-placeholder-img rounded-circle"
              width="140"
              height="140"
            />
            <h2>Alex M.</h2>
            <p>
              "I was skeptical about using a workout tracking site, but
              FitNation has exceeded my expectations. The site is user-friendly,
              the tracking tools are comprehensive, and the community is
              incredibly supportive. I've made so much progress towards my
              fitness goals thanks to FitNation!"
            </p>
          </div>
          <!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img
              src="Images/woman1.jpg"
              alt=""
              class="bd-placeholder-img rounded-circle"
              width="140"
              height="140"
            />
            <h2>Jane D.</h2>
            <p>
              "FitNation has made it so easy for me to track my workouts and
              stay on top of my fitness goals. The site is well-designed and
              easy to navigate, and the community is so supportive and
              encouraging. I'm so glad I found FitNation!"
            </p>
          </div>
          <!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img
              src="Images/football-trainer.jpg"
              alt=""
              class="bd-placeholder-img rounded-circle"
              width="140"
              height="140"
            />
            <h2>David T.</h2>
            <p>
              "As someone who is always on the go, it can be tough to stay
              motivated and track my workouts. But FitNation makes it easy! I
              can log my workouts on-the-go and the app reminds me to stay on
              track with my goals. It's like having a personal trainer in my
              pocket!"
            </p>
          </div>
          <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->

      <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>
          <a href="#">Join Now</a> ·
          <a href="#">Sign up</a>
        </p>
      </footer>
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
