
<?php
  $host_name = 'db5012579411.hosting-data.io';
  $database = 'dbs10574449';
  $user_name = 'dbu486281';
  $password = 'L@XXmwKtbZax6Gqo';
  $conn = null;

  try {
    $conn = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
  } catch (PDOException $e) {
    echo "Error!:" . $e->getMessage() . "<br/>";
    die();
  }
  // $conn = new PDO("mysql:host=localhost;dbname=cs347_project", "root", "");
?>