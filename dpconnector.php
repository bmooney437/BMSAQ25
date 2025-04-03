<?php
// dpconnector.php

$servername   = "localhost";      // Use "localhost" or "127.0.0.1"
$db_username  = "root";           // MAMP username
$db_password  = "root";           // MAMP password
$dbname       = "bmsaq";          // Your database name
$port         = 8889;             // MAMP default port
$socket       = "/Applications/MAMP/tmp/mysql/mysql.sock"; // MAMP socket

$conn = new mysqli($servername, $db_username, $db_password, $dbname, $port, $socket);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
