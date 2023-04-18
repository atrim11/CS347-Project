<?php
    // $timeout = 1800;
    // ini_set("session.gc_maxlifetime", $timeout);
    // ini_set("session.cookie_lifetime", $timeout);
    include("db_connection.php");

    session_start();

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
                $display_comments = $display_comments . 
                "<div class='comment'><h4>$username[Username]</h4><p>$comment[content]</p></div>";
            }
        }

        $display_posts = $display_posts . 
        "<div class='post'><a href='#'><h3>$username[Username]</h3></a><p>$log_post<br>" . 
        $display_comments ."</p></div>";
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
    <link rel="stylesheet" href="style.css" />
    <!-- Icon script -->
    <script src="https://kit.fontawesome.com/2b70e8a21a.js" crossorigin="anonymous"></script>
    <!-- Website Icon -->
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico">
    <title>FitNation</title>
</head>
<body>
    <?php
        include("navbar.php");
        if(isset($_SESSION['active']))
        {
          echo '<h2 align="center">Welcome '.htmlspecialchars($_SESSION['user_name']).'</h2>';
          echo '<p>Showing Latest Posts:</p>';
          echo $display_posts;
        }
    ?>
</body>
</html>