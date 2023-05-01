<?php
session_start();
// $timeout = 1800;
// ini_set("session.gc_maxlifetime", $timeout);
// ini_set("session.cookie_lifetime", $timeout);
include("db_connection.php");
include("auth.php");

if (!check_login()) {
  header("location:login.php");
  exit;
}

$url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
date_default_timezone_set('US/Eastern');

// Helper function to get the current user based on their id.
function get_user($user_id, $conn) {
  $get_user = "SELECT * FROM user WHERE user_id = ? LIMIT 1";
  $stmt = $conn->prepare($get_user);
  $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
  $stmt->execute();
  return $stmt->fetch();
}

// Helper function to get a post's total number of likes via post id.
function get_like_count ($post_id, $conn) {
  $get_likes = "SELECT * FROM likes WHERE post_id = ?";
  $stmt = $conn->prepare($get_likes);
  $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->rowCount();
}

// Helper function to get a post's total number of comments via post id.
function get_comment_count($post_id, $conn) {
    $get_comments = "SELECT * FROM comments WHERE post_id = ?";
    $stmt = $conn->prepare($get_comments);
    $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount();
}

// Helper function to get a post's liked status for the logged-in user.
function get_liked_status($user_id, $post_id, $conn) {
  $get_user_likes = "SELECT * FROM likes WHERE user_id = ? and post_id = ?";
  $stmt = $conn->prepare($get_user_likes);
  $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
  $stmt->bindParam(2, $post_id, PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount() > 0) {
    return "unlike";
  } else {
    return "like";
  }
}

// Helper function to get the deletion status for a given post.
// Allows for original make of the post or a Coach to delete posts.
function get_delete_status($user_id, $post_id, $conn) {
  $get_if_userpost = "SELECT * FROM log_posts WHERE user_id = ? and post_id = ?";
  $stmt = $conn->prepare($get_if_userpost);
  $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
  $stmt->bindParam(2, $post_id, PDO::PARAM_INT);
  $stmt->execute();
  if (get_user($user_id, $conn)["User_Type"] == "coach" || $stmt->rowCount() > 0) {
    return "<i class='delete fa-solid fa-trash fa-lg float-right' id='delete_$post_id'></i>";
  } else {
    return "";
  }
}

// Generates a set of posts and formats them to be displayed.
function generate_posts($posts, $conn, $user_info) {
  $all_posts = '';
  foreach ($posts as $post) {
    $log_post = $post["workout"];
  
    // User that posted the current log post.
    $username = get_user($post["user_id"], $conn);
  
    // Gets like count for the current post.
    $like_count = get_like_count($post["post_id"], $conn);
  
    // Gets comments of the current post (should probably be moved elsewhere)
    $comment_count = get_comment_count($post["post_id"], $conn);
  
    // Get whether the current user liked the current post.
    $liked = get_liked_status($user_info["user_id"], $post["post_id"], $conn);
    
    // Get whether the logged user can delete the current post.
    $delete = get_delete_status($username["user_id"], $post["post_id"], $conn);
  
    $all_posts = $all_posts . 
      "<div class='post'>
        <div class='post-body' id='post_$post[post_id]'>
          $delete
          <a href='user.php?user_id=$post[user_id]'<h6>$username[Username]</h6></a>
          <p class='post-text'>
          $log_post
          </p>
          <div class='post-footer'>
            <div class='post-footer-option'>
              <!-- like count-->
              <span id='like_count_$post[post_id]'>$like_count</span>
              <i class='$liked fa-solid fa-heart fa-lg' id='like_$post[post_id]'></i>
              <!-- Comment count-->
              <span id='comment_count_$post[post_id]'>$comment_count</span>  
              <i class='comment_blob fa-solid fa-message fa-lg' id='comment_$post[post_id]'></i>
              <span class='float-right'>$post[date]</span>
            </div>
          </div>
        </div>
      </div>";
  }
  return $all_posts;
}

$get_current_user = "SELECT * FROM user WHERE Username = ? LIMIT 1";
$stmt = $conn->prepare($get_current_user);
$stmt->bindParam(1, $_SESSION["user_name"], PDO::PARAM_STR);
$stmt->execute();
$user_info = $stmt->fetch();

$display_posts = '';

$get_posts = "SELECT * FROM log_posts";
$stmt = $conn->prepare($get_posts);
$stmt->execute();
$posts = $stmt->fetchAll();
$posts = array_reverse($posts);

$display_posts = generate_posts($posts, $conn, $user_info);

// Make the purple circle in Workouts actually be accurate
$get_user_post_count = "SELECT * FROM log_posts WHERE user_id = ?";
$stmt = $conn->prepare($get_user_post_count);
$stmt->bindParam(1, $user_info["user_id"], PDO::PARAM_INT);
$stmt->execute();
$workout_count = $stmt->rowCount();

// Get the current logged user's workouts
if (isset($_POST["user_workouts"])) {
  $workouts = $stmt->fetchAll();
  $response = "<i class='fa-solid fa-arrow-left' style='font-size: 16px' id='back'></i>";

  $response = $response . generate_posts($workouts, $conn, $user_info);
  echo $response;
  exit;
}

// Submit a workout log post.
if (isset($_POST["submit_post"])) {
    if (strlen($_POST["post_text"]) > 0) { 
        $new_post = "INSERT INTO log_posts (user_id, workout, date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($new_post);
        $stmt->bindParam(1, $user_info["user_id"], PDO::PARAM_INT);
        $stmt->bindParam(2, $_POST["post_text"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            $post_id = $conn->lastInsertId();
            $date = date('Y-m-d H:i:s');
            $response = "<div class='post'>
                          <div class='post-body' id='post_$post_id'>
                            <i class='fa-solid fa-trash fa-lg float-right' id='delete_$post_id'></i>
                            <a href='user.php?user_id=$user_info[user_id]'><h6>$user_info[Username]</h6></a>
                            <p class='post-text'>
                              $_POST[post_text]
                            </p>
                            <div class='post-footer'>
                              <div class='post-footer-option'>
                                <!-- like count -->
                                <span id='like_count_$post_id'>0</span>
                                <i class='like fa-solid fa-heart fa-lg' id='like_$post_id'></i>
                                <!-- Comment count -->
                                <span id='comment_count_$post_id'>0</span>
                                <i class='comment_blob fa-solid fa-message fa-lg' id='comment_$post_id'></i>
                                <span class='float-right'>$date</span>
                              </div>
                            </div>
                          </div>
                        </div>
            ";
            unset($_POST["submit_post"]);
            echo $response;
        }
    } else {
        unset($_POST["submit_post"]);
    }
    exit;
}

// Add like if a post's like button is hit.
if (isset($_POST["like"])) {
    $add_like = "INSERT INTO likes (user_id, post_id, date_time) VALUES (?, ?, NOW())";
    $create_like = $conn->prepare($add_like);
    $create_like->bindParam(1, $user_info["user_id"], PDO::PARAM_INT);
    $create_like->bindParam(2, $_POST["post_id"], PDO::PARAM_INT);
    $create_like->execute();
    unset($_POST["like"]);
    exit();
}
// Or remove like if post was already liked by this user. 
else if (isset($_POST["unlike"])) {
    $remove_like = "DELETE FROM likes WHERE post_id = ? and user_id = ?";
    $delete_like = $conn->prepare($remove_like);
    $delete_like->bindParam(1, $_POST["post_id"], PDO::PARAM_INT);
    $delete_like->bindParam(2, $user_info["user_id"], PDO::PARAM_INT);
    $delete_like->execute();
    unset($_POST["unlike"]);
    exit();
}

// Open a post in the scrollable section of the feed page.
if (isset($_POST["open_post"])) {
    // Big query to grab post data alongside comment data for that post.
    $get_current_post = "SELECT log_posts.workout, log_posts.post_id AS original_id, log_posts.user_id AS poster_id, 
    comments.post_id AS parent_post_id, comments.user_id AS commenter_id, comments.content, comments.date_time FROM log_posts INNER JOIN comments
    ON log_posts.post_id = comments.post_id WHERE log_posts.post_id = ?";
    $get_comments = $conn->prepare($get_current_post);
    $get_comments->bindParam(1, $_POST["post_id"], PDO::PARAM_INT);
    $get_comments->execute();
    $comments_with_post = $get_comments->fetchAll();

    // Get the post that was clicked on
    $get_post = "SELECT * FROM log_posts WHERE post_id = ?";
    $post_stmt = $conn->prepare($get_post);
    $post_stmt->bindParam(1, $_POST["post_id"], PDO::PARAM_INT);
    $post_stmt->execute();
    $post_info = $post_stmt->fetch();

    $response = array();
    // If there are comments to display.
    if ($get_comments->rowCount() > 0) {
        $opened_post = $comments_with_post[0];
        // Call each of the defined functions to grab data on the post.
        $poster_details = get_user($opened_post["poster_id"], $conn);
        $like_count = get_like_count($opened_post["original_id"], $conn);
        $comment_count = get_comment_count($opened_post["original_id"], $conn);
        $liked = get_liked_status($user_info["user_id"], $_POST["post_id"], $conn);
        $delete = get_delete_status($user_info["user_id"], $_POST["post_id"], $conn);

        // Format post.
        $response[0] = "<div class='post'>
                          <div class='post-body' name='main_post' id='post_large_$_POST[post_id]'>
                            <i class='fa-solid fa-lg fa-arrow-left' style='font-size: 16px' id='back'></i>
                            $delete
                            <a href='user.php?user_id=$poster_details[user_id]'><h6>$poster_details[Username]</h6></a>
                            <p class='post-text'>
                              $opened_post[workout]
                            </p>
                              <div class='post-footer'>
                                <div class='post-footer-option'>
                                  <!-- like count-->
                                  <span id='like_count_$_POST[post_id]'>$like_count</span>
                                  <i class='$liked fa-solid fa-heart fa-lg' id='like_$_POST[post_id]'></i>
                                  <!-- Comment count-->
                                  <span id='comment_count_$_POST[post_id]'>$comment_count</span>  
                                  <i class='comment_blob fa-solid fa-message fa-lg' id='comment_$_POST[post_id]'></i>
                                  <span class='float-right'>$post_info[date]</span>
                                </div>
                              </div>
                          </div>
                        </div>
                        <form id='create_comment' method='post' style='display: none;' onsubmit='return comment_submit()'>
                          <div class='form-group'>
                            <textarea class='form-control form-control-rounded' id='comment_text' name='post_text' rows='8'
                              placeholder='Write your message here...' required=''></textarea>
                          </div>
                          <div class='text-right'>
                            <button id='submit_comment' name='submit_comment' class='btn btn-primary' type='submit'>
                              Submit Comment
                            </button>
                          </div>
                        </form>";
        $i = 1;
        // For every comment, grab its data and format it.
        foreach ($comments_with_post as $comments) {
            $commenter = get_user($comments["commenter_id"], $conn);
            $response[$i] = "<div class = 'post'>
                                <div class='post-body'>
                                    <a href='user.php?user_id=$commenter[user_id]'><h6>$commenter[Username]</h6></a>
                                    <p class='post-text'>
                                        $comments[content]
                                    </p>
                                    <span class='float-right'>$comments[date_time]</span>
                                </div>
                            </div>";
            $i = $i + 1;
        }
        // Encode full response as a JSON to send back to JavaScript.
        echo json_encode($response);
    }
    // If no comments to display (the big query returns nothing if there are no comments). 
    else {
        // Call defined functions for getting post data.
        $poster = get_user($post_info["user_id"], $conn);
        $comment_count = get_comment_count($_POST["post_id"], $conn);
        $like_count = get_like_count($_POST["post_id"], $conn);
        $liked = get_liked_status($poster["user_id"], $_POST["post_id"], $conn);
        $delete = get_delete_status($user_info["user_id"], $_POST["post_id"], $conn);

        // Format the post.
        $response[0] = "<div class='post'>
                          <div class='post-body' name='main_post' id='post_large_$_POST[post_id]'>
                            <i class='fa-solid fa-lg fa-arrow-left' style='font-size: 16px' id='back'></i>
                            $delete
                            <a href='user.php?user_id=$poster[user_id]'><h6>$poster[Username]</h6></a>
                            <p class='post-text'>
                              $post_info[workout]
                            </p>
                            <div class='post-footer'>
                              <div class='post-footer-option'>
                                  <!-- like count-->
                                  <span id='like_count_$_POST[post_id]'>$like_count</span>
                                  <i class='$liked fa-solid fa-heart fa-lg' id='like_$_POST[post_id]'></i>
                                  <!-- Comment count-->
                                  <span id='comment_count_$_POST[post_id]'>$comment_count</span>  
                                  <i class='comment_blob fa-solid fa-message fa-lg' id='comment_$_POST[post_id]'></i>
                                  <span class='float-right'>$post_info[date]</span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <form id='create_comment' method='post' style='display: none;' onsubmit='return comment_submit()'>
                          <div class='form-group'>
                            <textarea class='form-control form-control-rounded' id='comment_text' name='post_text' rows='8'
                              placeholder='Write your message here...' required=''></textarea>
                          </div>
                          <div class='text-right'>
                            <button id='submit_comment' name='submit_comment' class='btn btn-primary' type='submit'>
                              Submit Comment
                            </button>
                          </div>
                        </form>";
        // Encode it as a JSON for returning to JavaScript.
        echo json_encode($response);
    }
    exit;
}

// If the user has created a comment and submitted it.
if (isset($_POST["submit_comment"])) {
  $create_comment = "INSERT INTO comments (user_id, post_id, date_time, content) VALUES (?, ?, NOW(), ?)";
  $comment_stmt = $conn->prepare($create_comment);
  $comment_stmt->bindParam(1, $user_info["user_id"], PDO::PARAM_INT);
  $comment_stmt->bindParam(2, $_POST["post_id"], PDO::PARAM_INT);
  $comment_stmt->bindParam(3, $_POST["comment_text"], PDO::PARAM_STR);
  $comment_stmt->execute();

  $date = date('Y-m-d H:i:s');
  $response = array();
  $response[0] = "<div class = 'post'>
                    <div class='post-body'>
                      <a href='user.php?user_id=$user_info[user_id]'><h6>$user_info[Username]</h6></a>
                      <p class='post-text'>
                        $_POST[comment_text]
                      </p>
                      <span class='float-right'>$date</span>
                    </div>
                  </div>";
  echo json_encode($response);
  unset($_POST["submit_comment"]);
  unset($_POST["post_id"]);
  unset($_POST["comment_text"]);

  exit;
}

if (isset($_POST["back"])) {
  $response = array();
  $response[0] = $display_posts;
  echo json_encode($response);
  unset($_POST["back"]);

  exit;
}

// If a delete has been approved by a user.
if (isset($_POST["delete"])) {
  $get_post_comments = "SELECT comment_id FROM comments WHERE post_id = ?";
  $comment_query = $conn->prepare($get_post_comments);
  $comment_query->bindParam(1, $_POST["post_id"], PDO::PARAM_INT);
  $comment_query->execute();
  $comments = $comment_query->fetchAll();
  
  foreach ($comments as $comment) {
    $delete_comment = "DELETE FROM comments WHERE comment_id = ?";
    $comment_query = $conn->prepare($delete_comment);
    $comment_query->bindParam(1, $comment["comment_id"], PDO::PARAM_INT);
    $comment_query->execute();
  }
  $delete_post = "DELETE FROM log_posts WHERE post_id = ?";
  $post_delete_query = $conn->prepare($delete_post);
  $post_delete_query->bindParam(1, $_POST["post_id"], PDO::PARAM_INT);
  $post_delete_query->execute();

  unset($_POST["post_id"]);
  unset($_POST["delete"]);
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/feed.css" />
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

  <!-- Scripts for navbar collapse and some styling -->
    <script
      src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"
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

  <title>FitNation</title>
</head>

<body>
  <?php
  include("navbar.php");
  ?>
  <!-- parts of this code are from a template
      https://www.bootdey.com/snippets/view/shop-user-profile-with-ticket -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <main>
    <div class="container padding-bottom-3x mb-2">
      <div class="row">
        <div class="col-lg-4" id="leftside">
          <aside class="user-info-wrapper" style="background-color: #7768AE">
            <div class="user-info">
              <div class="user-data">
                <?php 
                  $date = date_create($user_info["Date_Joined"]);
                  echo '<h4>' . htmlspecialchars($user_info['Username']) . '<h4>';
                  echo '<span>Joined ' . date_format($date, "m/d/y") . '</span>';
                ?>
              </div>
            </div>
          </aside>
          <nav class="list-group">
            <a class="list-group-item" href=".\user.php"><i class="fa fa-user"></i>Profile</a>
            <?php
            echo "<a class='list-group-item with-badge' href='javascript:show_users_workouts()'><i class='fa fa-th'></i>Workouts";
              if ($workout_count > 0) {
                echo "<span class='badge badge-primary badge-pill'>$workout_count</span></a>";
              } else {
                echo "<span class='badge badge-primary badge-pill'>Go Workout!</span></a>";
              }
            ?>
            <a class="list-group-item" href=".\sugg-workout.php"><i class="fa fa-th"></i>Suggested Workouts</a>
          </nav>
          <!-- Reply Form-->
          <form id="post_form" method="post" onsubmit="return post_submit()">
            <label for="review_text"><h5 class="mb-30 padding-top-1x">Post Your Workout</h5></label>
            <div class="form-group">
              <textarea class="form-control form-control-rounded" id="review_text" name="post_text" rows="8"
                placeholder="Write your message here..." required=""></textarea>
            </div>
            <div class="text-right">
              <button id="submit_post" name="submit_post" class="btn btn-primary" type="submit">
                Submit Workout
              </button>
            </div>
          </form>
        </div>
        <div class="col-lg-8" id="feed">
          <?php
              echo $display_posts;
          ?>
        </div>
      </div>
    </div>
</main>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <script>
      function show_users_workouts() {
        let feed = document.getElementById("feed");
        $.ajax({
          url: "feed.php",
          type: "post",
          async: false,
          data: {
                'user_workouts': 1
          },
          success: function(response) {
            console.log(response);
            feed.innerHTML = '';
            feed.innerHTML = response;
          }
        })
      }
    </script>
    <script>
      // Function to submit a post and update the html to display the new post.
      function post_submit() {
        let feed = document.getElementById("feed");
        let post_text = document.getElementById("review_text").value;
        let workout_count = document.querySelector(".badge-pill");
        $.ajax({
          url: "feed.php",
          type: "post",
          async: false,
          data: {
                'submit_post': 1,
                'post_text': post_text
          },
          success: function(response) {
            // If there is post text and check if on a post/comments screen rather than the feed.
            if (response){
              if (!window.location.href.includes('?')) {
                feed.innerHTML = response + feed.innerHTML;
              }
              workout_count.innerText = parseInt(workout_count.innerText) + 1;
              alert('Log post successfully created!');
            } else {
              alert('You must enter text into the textbox to post!');
            }
          }
        });
        return false;
      }
    </script>
    <script>
      function comment_submit() {
        let feed = document.getElementById("feed");
        let post = document.getElementsByName("main_post")[0];
        let postId = parseInt(post.id.split('_')[2]);
        let comment_count = document.getElementById(`comment_count_${postId}`);
        let comment = document.querySelector("#comment_text").value;
        $.ajax({
          url: "feed.php",
          type: "post",
          async: false,
          data: {
                  'post_id': postId,
                  'comment_text': comment,
                  'submit_comment': 1
          }, 
          success: function(response) {
            let resp = JSON.parse(response);
            comment_count.innerText = parseInt(comment_count.innerText) + 1;
            resp.forEach(element => feed.innerHTML += element);
          }
        })
        return false;
      }
    </script>
    <script>
        // Event Listener for clicking on different profiles or 
        // buttons or whatever have you. Detects clicks properly,
        // but comment part does not work.
        document.addEventListener('click', function(e) {
              // Listener for comment bubble interaction
              if(e.target && (/comment_([0-9])+/.test(e.target.id))) {
                let create_comment = document.getElementById("create_comment");
                if (create_comment && create_comment.style.display == "none") {
                  create_comment.style.display = "block";
                } else if (create_comment && create_comment.style.display == "block") {
                  create_comment.style.display = "none";
                }
              } 
              // Listener for like button interaction.
              else if (e.target && (/like_/.test(e.target.id))) {
                  postLike = e.target;
                  let postId = parseInt(postLike.id.split('_')[1]);
                  let like_count_elem = document.getElementById(`like_count_${postId}`);
                  if (postLike.classList.contains("like")) {
                    postLike.classList.add("unlike");
                    postLike.classList.remove("like");
                    like_count_elem.innerText = parseInt(like_count_elem.innerText) + 1;
                    $.ajax({
                        url: "feed.php",
                        type: "post",
                        async: false,
                        data: {
                            'like': 1,
                            'post_id': postId
                        },
                        success: function() {
                        }
                    });
                  } else if (postLike.classList.contains("unlike")) {
                    postLike.classList.add("like");
                    postLike.classList.remove("unlike");
                    like_count_elem.innerText = parseInt(like_count_elem.innerText) - 1;
                    $.ajax({
                        url: "feed.php",
                        type: "post",
                        async: false,
                        data: {
                            'unlike': 1,
                            'post_id': postId
                        },
                        success: function() {
                        }
                    });
                  }
              } 
              // Listener for delete button interaction.
              else if (e.target && (/delete_([0-9])+/).test(e.target.id)) {
                  let confirmation = confirm("Would you like to delete this post?");
                  if (confirmation) {
                    let postId = parseInt(e.target.id.split('_')[1]);
                    let post = e.target.parentNode;
                    let feed = document.getElementById("feed");
                    $.ajax({
                      url: "feed.php",
                      type: "post",
                      async: false,
                      data: {
                          'delete': 1,
                          'post_id': postId
                      },
                      success: function() {
                        alert("Post successfully deleted!");
                        post.remove();
                        if (window.location.href.includes('?')) {
                          feed.innerHTML = '';
                          feed.innerHTML += "<div class='post'><div class='post-body'><p class='post-text'>We're sorry, but you must go <b id='back'>back to the feed page</b>.</p></div></div>";
                        }
                      }
                    });
                  }
              }
              // Listener for clicking on a post. 
              else if (e.target && (/post_([0-9])+/.test(e.target.id) || /post_([0-9])/.test(e.target.parentNode.id))) {
                  let posts = document.getElementById("feed");
                  let postId = parseInt(e.target.id.split('_')[1]) || parseInt(e.target.parentNode.id.split('_')[1]);
                  $.ajax({
                    url: "feed.php",
                    type: "post",
                    async: false,
                    data: {
                        'open_post': 1,
                        'post_id': postId
                    },
                    success: function(response) {
                        // If success, parse JSON respone and put it to the screen.
                        console.log(response);
                        window.history.pushState({additionalInformation: "Viewing a post"}, "FitNation", window.location.href.split('?')[0] + `?post_id=${postId}&open_post=1`);
                        posts.innerHTML = '';
                        let server_rsp = JSON.parse(response);
                        server_rsp.forEach(element => posts.innerHTML += element);
                    }
                  });
              }
              // Listener for clicking on a back to feed button 
              else if (e.target && e.target.id == "back") {
                let feed = document.getElementById("feed");
                $.ajax({
                  url: "feed.php",
                  type: "post",
                  async: false,
                  data: {
                    'back': 1
                  },
                  success: function(response) {
                    window.history.pushState({additionalInformation: "Main feed for FitNation"}, "FitNation", window.location.href.split("?")[0]);
                    let server_resp = JSON.parse(response);
                    feed.innerHTML = '';
                    server_resp.forEach(element => feed.innerHTML += element);
                  }
                });
              }
          });

    </script>
</body>

</html>