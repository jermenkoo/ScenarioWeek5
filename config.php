<?php
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = 't*_41sRwJw-jvHR';
  $conn = new PDO('mysql:dbname=test_db;host=' . $dbhost . ';charset=utf8', $dbuser, $dbpass);

  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
?>
