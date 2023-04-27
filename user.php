<?php
  session_start();
  if (!isset($_SESSION["user_name"])) {
    header("location:index.php");
  } 
  include("db_connection.php");
  include("auth.php");

  if(isset($_POST['liked'])) {

    $create_new_like = $conn->prepare("
    INSERT INTO likes (user_id, post_id, date_time)
    VALUES (?, ?, NOW())
    ");
    $create_new_like->bindParam(1, $_SESSION["user_id"]);
    $create_new_like->bindParam(2, $_POST['postid']);
    $create_new_like->execute();
    exit();

  }

  if(isset($_POST["unliked"])) {

    $q = $conn->prepare("
    DELETE FROM likes 
    WHERE post_id = ? and user_id = ?
    ");
    $q->bindParam(1, $_POST["postid"]);
    $q->bindParam(2, $_SESSION["user_id"]);
    $q->execute();
    exit();

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
    <!-- <link rel="stylesheet" href="css/feed.css">  -->
    <style>
      .like {
        color: gray;
      }

      .like:hover {
        color: red;
      } 
      
      .unlike {
        color:red;
      }

      .unlike:hover {
        color: gray;
      } 
      

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
                          foreach($result as $row) { ?>
                            <div class='post'>
                              <div class='post-body'>
                                <h6><?php echo $_SESSION['user_name']?></h6> 
                                <p class='post-text'>
                                <?php echo $row["workout"]?>
                                </p>
                                <div class='post-footer'>
                                  <div class='post-footer-option'>
                                    <!-- like count-->
                                    <?php 
                                    $all_entries_for_likes = $conn->prepare("
                                    SELECT * FROM likes
                                    where post_id = ?
                                    ");
                                    $all_entries_for_likes->bindParam(1, $row["post_id"]);
                                    $all_entries_for_likes->execute();
                                    ?>
                                    <span id="like-count-for-<?php echo$row["post_id"]?>"><?php echo $all_entries_for_likes->rowCount() ?></span>
                                    <?php

                                    // determine if user has already liked the post
                                    $query = $conn->prepare("
                                    SELECT * FROM likes
                                    where user_id = ? AND post_id = ?
                                    ");
                                    $query->bindParam(1, $_SESSION["user_id"]);
                                    $query->bindParam(2, $row["post_id"]);
                                    $query->execute();
                                    $unique_count = $query->rowCount();
                                  
                                    if ($unique_count > 0) {
                                      // user has liked the post?>
                                      <i class='unlike fa-solid fa-heart fa-lg liker' id="<?php echo $row["post_id"]?>" ></i>
                                    <?php
                                    } else {
                                      // user has not liked the post
                                    ?>
                                      <i class='like fa-solid fa-heart fa-lg liker' id="<?php echo $row["post_id"]?>" ></i>
                                    <?php
                                    }
                                    ?>

                                    <!-- Comment count-->
                                    <span>0</span>  
                                    <i class='fa-solid fa-message fa-lg'></i>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php
                          }

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

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
      
      // user clicks on like
      $(document).ready(function() {
        $('.liker').click(function(){
          var postid = $(this).attr('id');
          if ($(this).hasClass("like")) {
            $(this).addClass("unlike");
            $(this).removeClass("like");
            id = "like-count-for-"+$(this).attr('id');
            like_count_elem = document.getElementById(id)
            like_count_elem.innerText = parseInt(like_count_elem.innerText) + 1
            $.ajax({
              url: 'user.php',
              type: 'post',
              async: false,
              data: {
                'liked':1,
                'postid': postid
              },
              success:function(){
              }
            })
          } else {
            $(this).addClass("like");
            $(this).removeClass("unlike");
            id = "like-count-for-"+$(this).attr('id');
            like_count_elem = document.getElementById(id)
            like_count_elem.innerText = parseInt(like_count_elem.innerText) - 1
            $.ajax({
              url: 'user.php',
              type: 'post',
              async: false,
              data: {
                'unliked':1,
                'postid': postid
              },
              success:function(){

              }
            })
          }
        })

        
      });

    </script>
  </body>
</html>
