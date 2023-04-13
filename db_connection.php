
<?php
$servername = "db5012579411.hosting-data.io";
$username = "dbu486281";
$password = "L@XXmwKtbZax6Gqo";
$database = "dbs10574449";
// create connection
$connect = mysqli_connect($servername, $username, $password, $database);
// check connection
if (!$connect) {
  die("Connection failed: " . mysqli_connect_error());
}

// $conn = new PDO("mysql:host=localhost;dbname=cs347_project", "root", "");

?>