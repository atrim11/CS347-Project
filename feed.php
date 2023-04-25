<?php
session_start();
// $timeout = 1800;
// ini_set("session.gc_maxlifetime", $timeout);
// ini_set("session.cookie_lifetime", $timeout);
include("db_connection.php");

if (!isset($_SESSION["active"])) {
  header("location:login.php");
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

foreach ($posts as $post) {
  $log_post = $post["workout"];

  $get_user = "SELECT Username FROM user WHERE user_id = ? LIMIT 1";
  $stmt = $conn->prepare($get_user);
  $stmt->bindParam(1, $post["user_id"], PDO::PARAM_STR);
  $stmt->execute();
  $username = $stmt->fetch();

  $get_comments = "SELECT * FROM comments WHERE post_id = ?";
  $stmt = $conn->prepare($get_comments);
  $stmt->bindParam(1, $post["post_id"], PDO::PARAM_INT);
  $stmt->execute();

  //IF YOU ARE GOING TO UNCOMMENT THIS, USE A DIFFERENT VARIABLE THAN $username.
  //IT WILL OVERWRITE THE USERNAME OF THE POSTER OTHERWISE.
  
  $display_comments = '';
  if ($stmt->rowCount() > 0) {
    $comments = $stmt->fetchAll();
    foreach ($comments as $comment) {
      $user_query = "SELECT Username FROM user WHERE user_id = ? LIMIT 1";
      $stmt = $conn->prepare($user_query);
      $stmt->bindParam(1, $comment["user_id"], PDO::PARAM_INT);
      $stmt->execute();
      $comment_username = $stmt->fetch();
    //   $display_comments = $display_comments .
        // "<div class='comment'><h4>$comment_username[Username]</h4><p>$comment[content]</p></div>";
    }
  }

  // Comment count
  $comment_count = $stmt->rowCount();

  $display_posts = $display_posts . 
    "<div class='post'>
      <div class='post-body' id='post_$post[post_id]'>
        <h6>$username[Username]</h6> 
        <p class='post-text'>
        $log_post
        </p>
        <div class='post-footer'>
          <div class='post-footer-option'>
            <!-- like count-->
            <span>0</span>
            <button class='btn' id='like_$post[post_id]'><i class='fa-solid fa-heart fa-lg'></i></button>
            <!-- Comment count-->
            <span>$comment_count</span>  
            <button class='btn' id='comment_$post[post_id]'><i class='fa-solid fa-message fa-lg'></i></button>
          </div>
        </div>
      </div>
    </div>";
}

// Make the blue circle in Workouts actually be accurate
$get_user_post_count = "SELECT * FROM log_posts WHERE user_id = ?";
$stmt = $conn->prepare($get_user_post_count);
$stmt->bindParam(1, $user_info["user_id"], PDO::PARAM_INT);
$stmt->execute();
$workout_count = $stmt->rowCount();


if (isset($_POST["submit_post"])) {
    if (strlen($_POST["post_text"]) > 0) { 
        $new_post = "INSERT INTO log_posts (user_id, workout, date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($new_post);
        $stmt->bindParam(1, $user_info["user_id"], PDO::PARAM_INT);
        $stmt->bindParam(2, $_POST["post_text"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            echo "<script type='text/javascript'>alert('Log post successfully created!');</script>";
            unset($_POST["submit_post"]);
        }
    } else {
        echo "<script type='text/javascript'>alert('You must enter text into the textbox to post!');</script";
        unset($_POST["submit_post"]);
    }
}

// EITHER OF THE BELOW SHOULD WORK IF IT'S WORKING PROPERLY. 
// $data = json_decode(file_get_contents('php://input'), true);
// if (isset($_POST["foo"])) {
    // print_r($_POST);
    // echo "<script>console.log('foo is set');</script>";
    // if ($_POST["foo"] == "bar") {
        // echo "<script>console.log('bar has been found');</script>";
    // }
// }
if (array_key_exists('foo', $_POST)) {
    $bar = $_POST['foo'];
    echo json_encode('IT WORKS!');
    echo $bar;
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

  <title>FitNation</title>
</head>

<body>
  <?php
  include("navbar.php");
  ?>
  <!-- parts of this code are from a template
      https://www.bootdey.com/snippets/view/shop-user-profile-with-ticket -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <div class="container padding-bottom-3x mb-2">
    <div class="row">
      <div class="col-lg-4" id="leftside">
        <aside class="user-info-wrapper">
          <div class="user-info">
            <div class="user-data">
              <?php 
            //   echo '<h4>' . htmlspecialchars($_SESSION['user_name']) . '</h4>';
            //   echo '<span>Joined ' . $_SESSION['date_joined'] . '</span>';
                echo '<h4>' . htmlspecialchars($user_info['Username']) . '<h4>';
                echo '<span>Joined ' . $user_info['Date_Joined'] . '</span>';
              ?>
              <!-- <span>Joined February 06, 2017</span> -->
            </div>
          </div>
        </aside>
        <nav class="list-group">
          <a class="list-group-item" href="#"><i class="fa fa-user"></i>Profile</a>
          <?php
          echo "<a class='list-group-item with-badge' href='#'><i class='fa fa-th'></i>Workouts";
            if ($workout_count > 0) {
              echo "<span class='badge badge-primary badge-pill'>$workout_count</span></a>";
            } else {
              echo "<span class='badge badge-primary badge-pill'>Go Workout!</span></a>";
            }
          ?>
          <a class="list-group-item" href=".\sugg-workout.php"><i class="fa fa-th"></i>Suggested Workouts</a>
        </nav>
        <!-- Reply Form-->
        <h5 class="mb-30 padding-top-1x">Post Your Workout</h5>
        <form id="post_form" method="post">
          <div class="form-group">
            <textarea class="form-control form-control-rounded" id="review_text" name="post_text" rows="8"
              placeholder="Write your message here..." required=""></textarea>
          </div>
          <div class="text-right">
            <button id="submit_post" name="submit_post" class="btn btn-outline-primary" type="submit">
              Submit Workout
            </button>
          </div>
        </form>
      </div>
      <div class="col-lg-8" id="feed">
        <?php
        echo $display_posts;
        ?>
        <!-- <div class="comment">
            <div class="comment-body">
              <p class="comment-text">
                At vero eos et accusamus et iusto odio dignissimos ducimus qui
                blanditiis praesentium voluptatum deleniti atque corrupti quos
                dolores et quas molestias excepturi sint occaecati cupiditate
                non provident, similique sunt in culpa qui officia deserunt
                mollitia animi.
              </p>
              <div class="comment-footer">
                <span class="comment-meta">Daniel Adams</span>
              </div>
            </div>
          </div> -->
      </div>
    </div>
  </div>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <script>
        // Event Listener for clicking on different profiles or 
        // buttons or whatever have you. Detects clicks properly,
        // but comment part does not work.
        document.addEventListener('click', function(e) {
              if(e.target && (/comment_/.test(e.target.id) || /comment_/.test(e.target.parentNode.id))) {
                  let postId = e.target.id.split('_')[1] || e.target.parentNode.id.split('_')[1];
                  window.open(`post_details.php?post_id=${postId}`, '_blank');
              } else if (e.target && (/like_/.test(e.target.id) || /like_/.test(e.target.parentNode.id))) {
                  console.log("this is like");
              } else if (e.target && (/post_([0-9])+/.test(e.target.id) || /post_([0-9])/.test(e.target.parentNode.id))) {
                  console.log("this is post");
              }
          });

    </script>
</body>

</html>