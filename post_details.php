<?php
include("db_connection.php");

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if ($post_id === 0) {
    echo "Invalid post ID";
    exit;
}

$get_post = "SELECT * FROM log_posts WHERE post_id = ? LIMIT 1";
$stmt = $conn->prepare($get_post);
$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch();

$get_user = "SELECT Username FROM user WHERE user_id = ? LIMIT 1";
$stmt = $conn->prepare($get_user);
$stmt->bindParam(1, $post["user_id"], PDO::PARAM_INT);
$stmt->execute();
$username = $stmt->fetch();

$get_comments = "SELECT * FROM comments WHERE post_id = ?";
$stmt = $conn->prepare($get_comments);
$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Post Details</title>
</head>
<body>
  <h1><?php echo $post["workout"]; ?></h1>
  <p>Posted by: <?php echo $username["Username"]; ?></p>
  <h2>Comments</h2>
  <?php foreach ($comments as $comment): ?>
    <div>
      <p><?php echo $comment["content"]; ?></p>
    </div>
  <?php endforeach; ?>
</body>
</html>
