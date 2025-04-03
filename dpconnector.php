<?php
// dpconnector.php
$servername   = "localhost"; 
$db_username  = "root";
$db_password  = "root";
$dbname       = "bmsaq";
$port         = 8889;
$socket       = "/Applications/MAMP/tmp/mysql/mysql.sock";

$conn = new mysqli($servername, $db_username, $db_password, $dbname, $port, $socket);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
