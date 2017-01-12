<?php
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = 'root';
  // $conn = mysql_connect($dbhost, $dbuser, $dbpass);
  $conn = new PDO('mysql:dbname=test_db;host=' . $dbhost . ';charset=utf8', $dbuser, $dbpass);

  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
?>
