<?php
  $host_name = 'db5012579411.hosting-data.io';
  $database = 'dbs10574449';
  $user_name = 'dbu486281';
  $password = 'L@XXmwKtbZax6Gqo';

  $link = new mysqli($host_name, $user_name, $password, $database);

  if ($link->connect_error) {
    die('<p>Failed to connect to MySQL: '. $link->connect_error .'</p>');
  } else {
    echo '<p>Connection to MySQL server successfully established.</p>';
  }

  //$conn = new PDO("mysql:host=localhost;dbname=cs347_project", "root", "");
?>