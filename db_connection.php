
<?php
$servername = "db5012579411.hosting-data.io";
$username = "dbu486281";
$password = "L@XXmwKtbZax6Gqo";
$database = "dbs10574449";
// create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";



// try {
//   $conn = new PDO("mysql:host=$servername;dbname=dbs10574449", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
// } catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
// }
?>