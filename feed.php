<?php
session_start();
// $timeout = 1800;
// ini_set("session.gc_maxlifetime", $timeout);
// ini_set("session.cookie_lifetime", $timeout);
include("db_connection.php");


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

  $display_comments = '';
  if ($stmt->rowCount() > 0) {
    $comments = $stmt->fetchAll();
    foreach ($comments as $comment) {
      $user_query = "SELECT Username FROM user WHERE user_id = ? LIMIT 1";
      $stmt = $conn->prepare($user_query);
      $stmt->bindParam(1, $comment["user_id"], PDO::PARAM_INT);
      $stmt->execute();
      $username = $stmt->fetch();
    //   $display_comments = $display_comments .
        // "<div class='comment'><h4>$username[Username]</h4><p>$comment[content]</p></div>";
    }
  }

  $display_posts = $display_posts .
    "<div class='post'>
      <div class='post-body'>
        <h6>$username[Username]</h6> 
        <p class='post-text'>
        $log_post
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
    </div>";
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
  <title>FitNation</title>
</head>

<body>
  <?php
  include("navbar.php");
  // if (isset($_SESSION['user_name'])) {
  //   echo '<h2 align="center">Welcome ' . htmlspecialchars($_SESSION['user_name']) . '</h2>';
  //   // echo $display_posts;
  // }
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
              echo '<h4>' . htmlspecialchars($_SESSION['user_name']) . '</h4>';
              echo '<span>Joined ' . $_SESSION['date_joined'] . '</span>';
              ?>
              <!-- <span>Joined February 06, 2017</span> -->
            </div>
          </div>
        </aside>
        <nav class="list-group">
          <a class="list-group-item" href="#"><i class="fa fa-user"></i>Profile</a>
          <a class="list-group-item with-badge" href="#"><i class="fa fa-th"></i>Workouts<span
              class="badge badge-primary badge-pill">6</span></a>
          <a class="list-group-item" href="#"><i class="fa fa-th"></i>Suggested Workouts</a>
        </nav>
        <!-- Reply Form-->
        <h5 class="mb-30 padding-top-1x">Post Your Workout</h5>
        <form method="post">
          <div class="form-group">
            <textarea class="form-control form-control-rounded" id="review_text" rows="8"
              placeholder="Write your message here..." required=""></textarea>
          </div>
          <div class="text-right">
            <button class="btn btn-outline-primary" type="submit">
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
</body>

</html>