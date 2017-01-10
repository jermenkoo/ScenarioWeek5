<?php
  include 'config.php';
  $db = 'test_db';

  function validCredentials($username, $password){
    global $conn;
    global $db;
    $sql = sprintf("SELECT id FROM `user` WHERE username='%s' and password='%s'", $username, $password);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn );
    if (mysql_num_rows($retval) == 1) {
      return [true, mysql_result($retval, 0)];
    } else { return [false, -1]; }
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
  function setPrivSnippet($id, $snippet){
    global $conn;
    global $db;

    $sql = sprintf("UPDATE  `user` SET privSnippet='%s' WHERE id=%s;", $snippet, $id);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      die('Could not update private snippet: ' . mysql_error());
    }
  }
  function getPrivSnippet($id){
    global $conn;
    global $db;
    $sql = sprintf("SELECT privSnippet FROM user WHERE id=%s;", $id);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      die('Could not get private snippet: ' . mysql_error());
    }
    $result = mysql_result($retval, 0);
    return $result;
  }
  function getAllUsers() {
    global $db;
    global $conn;
    $sql = sprintf("SELECT * FROM user");
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn);
    if (!$retval) {
      die('Could not get users: ' . mysql_error());
    }
    $arr = array();
    while ($res = mysql_fetch_array($retval, MYSQL_BOTH)){
      $arr[] = $res;
    }
    return $arr;
  }
  function createSnippet($snippet, $userId){
    global $conn;
    global $db;
    $sql = sprintf("INSERT INTO snippet (userId, snippet) VALUES ('%s', '%s');", $userId, $snippet);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn );
    if (!$retval) {
      die('Could not create snippet: ' . mysql_error());
    }
  }
  function getPublicSnippet($userId){
    global $db;
    global $conn;
    $sql = sprintf("SELECT snippet FROM snippet WHERE userId=%s ORDER BY createdAt DESC", $userId);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn);
    if (!$retval) {
      die('Could not get snippets: ' . mysql_error());
    }
    $result = mysql_result($retval, 0);
    return $result;
  }
  function deleteSnippet($snippetId){
      global $db;
      global $conn;
      $sql = sprintf("DELETE * FROM snippet WHERE id=%s", $snippetId);
      mysql_select_db($db);
      return;
  }
  function getAllSnippets($userId){
    global $db;
    global $conn;
    $sql = sprintf("SELECT snippet,id FROM snippet WHERE userId=%s ORDER BY createdAt DESC", $userId);
    mysql_select_db($db);
    $retval = mysql_query( $sql, $conn);
    if (!$retval) {
      die('Could not get snippets: ' . mysql_error());
    }
    $arr = array();
    while ($res = mysql_fetch_array($retval, MYSQL_BOTH)){
      $arr[] = $res;
    }
    return $arr;
  }
?>
