<?php
  $dbhost = 'localhost:3036';
  $dbuser = 'root';
  $dbpass = 'root';
  $conn = mysql_connect($dbhost, $dbuser, $dbpass);
  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
?>
