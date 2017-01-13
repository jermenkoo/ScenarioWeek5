<?php
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = 't*_41sRwJw-jvHR';

  foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }

    $dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $dbuser = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $dbpass = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
  }

  $conn = new PDO('mysql:dbname=test_db;host=' . $dbhost . ';charset=utf8', $dbuser, $dbpass);

  if (!$conn) {
    die('Could not connect: ' . mysql_error());
  }
?>
