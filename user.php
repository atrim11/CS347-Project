<?php
  session_start();
  if (!isset($_SESSION["user_name"])) {
    header("location:index.php");
  } 
  include("db_connection.php");

  // $user_query = "
  // SELECT * FROM user
  // WHERE Username = ?
  // ";

  // $user_info = $conn->prepare($user_query);
  // $user_info->bindParam(1, $_SESSION["user_name"]);
  // $user_info->execute();


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
    <!-- <link rel="stylesheet" href="css/feed.css">  -->
    <style>
      .post {
          display: block;
          position: relative;
          margin-bottom: 30px;
      }

      .post .post-author-ava {
          display: block;
          position: absolute;
          top: 0;
          left: 0;
          width: 50px;
          border-radius: 50%;
          overflow: hidden
      }

      .post .post-author-ava>img {
          display: block;
          width: 100%
      }

      .post .post-body {
          position: relative;
          padding: 24px;
          border: 1px solid #e1e7ec;
          border-radius: 7px;
          background-color: #fff
      }

      .post .post-body::after {
          border-width: 9px;
          border-color: transparent;
          border-right-color: #fff
      }

      .post .post-body::before {
          margin-top: -1px;
          border-width: 10px;
          border-color: transparent;
          border-right-color: #e1e7ec
      }

      .post .post-title {
          margin-bottom: 8px;
          color: #606975;
          font-size: 14px;
          font-weight: 500
      }

      .post .post-text {
          margin-bottom: 12px
      }

      .post .post-footer {
          display: table;
          width: 100%
      }

      .post .post-footer>.column {
          display: table-cell;
          vertical-align: middle
      }

      .post .post-footer>.column:last-child {
          text-align: right
      }

      .post .post-meta {
          color: #9da9b9;
          font-size: 13px
      }

      .post .reply-link {
          transition: color .3s;
          color: #606975;
          font-size: 14px;
          font-weight: 500;
          letter-spacing: .07em;
          text-transform: uppercase;
          text-decoration: none
      }

      .post .reply-link>i {
          display: inline-block;
          margin-top: -3px;
          margin-right: 4px;
          vertical-align: middle
      }

      .post .reply-link:hover {
          color: #0da9ef
      }

      .post.post-reply {
          margin-top: 30px;
          margin-bottom: 0
      }

      @media (max-width: 576px) {
          .post {
              padding-left: 0
          }
          .post .post-author-ava {
              display: none
          }
          .post .post-body {
              padding: 15px
          }
          .post .post-body::before,
          .post .post-body::after {
              display: none
          }
      }
    </style>
    <!-- Icon script -->
    <script
      src="https://kit.fontawesome.com/2b70e8a21a.js"
      crossorigin="anonymous"
    ></script>
    <!-- Website Icon -->
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico" />
    <title>FitNation</title>
  </head>
  <body>
    <header>
      <?php
        include("navbar.php");
      ?>
    </header>
    <body>
      <div class="container">
        <div class="main-body">

              <!-- /Breadcrumb -->
              <br>
              <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-column align-items-center text-center">
                        <!-- Profile pic <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150"> -->
                        <i class="fa fa-user fa-2xl"></i>
                        <div class="mt-3">
                          <!-- User Name Display -->
                          <h4>
                            <?php
                            echo $_SESSION["user_name"];
                            ?>
                          </h4>
                          <p class="text-secondary mb-1">
                            <!-- Displays Date Joined -->
                            <?php 
                            $date = date_create($_SESSION["date_joined"]);
                            echo "Joined: ".date_format($date,"m/d/Y");
                            ?>
                            
                          </p>
                          <p class="text-muted font-size-sm">Athlete or Coach</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">Personal Data</h6> 
                        <span class="text-secondary">Data</span>
                      </li>
                      
                    </ul>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          -
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          -
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          -
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                          -
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-sm-12">
                          <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-3">
                          <h6 class="mb-0">Posts</h6>
                        </div>
                      </div>
                      <br>

                      <!-- iterates through posts of a user and creates them -->
                      <?php
                        $post_query = "
                        SELECT * FROM log_posts
                        WHERE user_id = ?
                        ";

                        $posts = $conn->prepare($post_query);
                        $posts->bindParam(1, $_SESSION["user_id"]);
                        $posts->execute();

                        $count = $posts->rowCount();

                        if ($count == 0) {
                          echo "<p>No Posts Yet</p>";
                        } else {
                          $result = $posts->fetchAll();
                          $posts_from_user = "";
                          foreach ($result as $row) {
                            $posts_from_user = $posts_from_user.
                            "
                              <div class='post'>
                                <div class='post-body'>
                                  <h6>".$_SESSION["user_name"]."</h6> 
                                  <p class='post-text'>
                                  ".$row["workout"]."
                                  </p>
                                  <div class='post-footer'>
                                    <div class='post-footer-option'>
                                      <!-- like count-->
                                      <span>0</span>
                                      <i class='fa-solid fa-heart fa-lg'></i>
                                      <!-- Comment count-->
                                      <span>0</span>  
                                      <i class='fa-solid fa-message fa-lg'></i>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            "; 
                          }
                          echo $posts_from_user;
                        }

                      ?> 
                    </div>
                  </div> 
                </div>
              </div>
    
            </div>
        </div>
    </body>
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
