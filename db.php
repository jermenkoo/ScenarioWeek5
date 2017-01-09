<?php
  include 'config.php';
  function loggedIn($username, $password){
    global $conn;
    $sql = sprintf("SELECT * FROM `user` WHERE username='%s' and password='%s'", $username, $password);
    mysql_select_db('test_db');
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      return false;
    }
    return true;
  }
  function createUser($username, $password){
    global $conn;
    $sql = sprintf("INSERT INTO user (username, password, isAdmin) VALUES ('%s', '%s', 0);", $username, $password);
    mysql_select_db('test_db');
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      die('Could not create user: ' . mysql_error());
    }
  }
  loggedIn("marco", "123");
?>
