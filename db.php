<?php
  include 'config.php';
  $db = 'test_db'; 

  function loggedIn($username, $password){
    global $conn;
    global $db;
    $sql = sprintf("SELECT * FROM `user` WHERE username='%s' and password='%s'", $username, $password);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      return false;
    } else { return true; }
  }
  function createUser($username, $password){
    global $conn;
    global $db;

    $sql = sprintf("INSERT INTO user (username, password, isAdmin) VALUES ('%s', '%s', 0);", $username, $password);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      die('Could not create user: ' . mysql_error());
    }
  }
  function setColour($id, $color){
    global $conn;
    global $db;

    $sql = sprintf("UPDATE  `user` SET colour='%s' WHERE id=%s;", $color, $id);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      die('Could not update colour: ' . mysql_error());
    }
  }
  function getColour($id){
    global $conn;
    global $db;
    $sql = sprintf("SELECT colour FROM user WHERE id=%s;", $id);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      die('Could not get colour: ' . mysql_error());
    }
    $result = mysql_result($retval, 0);
    return $result;
  } 
  function getAllUsers() {
    global $db;
    global $conn;
    $sql = sprintf("SELECT * FROM `user`");
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn);
    if (!$retval) {
      die('Could not get users: ' . mysql_error());
    }
    return mysql_fetch_array($retval);
  }
?>
