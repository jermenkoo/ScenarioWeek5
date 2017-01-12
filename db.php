<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);
?>

<?php
  include 'config.php';
  $db = 'test_db';

  function validCredentials($username, $password){
    global $conn;
    // global $db;
    //$sql = sprintf("SELECT id, isAdmin FROM `user` WHERE username='%s' and password='%s'", $username, $password);
    // mysql_select_db($db);
    //$retval = mysql_query( $sql, $conn );
    $retval = $conn->prepare("SELECT id, isAdmin FROM user WHERE username = :name and password = :password;");
    $retval->execute(array('name' => $username, 'password' => md5($password)));
    foreach ($retval as $row) {
      return [true, $row['id'], $row['isAdmin']];
    }

    return [false, -1, -1];
  }
  function createUser($username, $password){
    global $conn;
    // global $db;
    // $sql = sprintf("INSERT INTO user (username, password, isAdmin) VALUES ('%s', '%s', 0);", $username, $password);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("INSERT INTO user (username, password, isAdmin) VALUES (:username, :password, 0);");
    $retval->execute(array('username' => $username, 'password' => md5($password)));

    if (!$retval) {
      die('Could not create user: ' . mysql_error());
    }
  }
  function setColour($id, $color){
    global $conn;
    // global $db;
    // $sql = sprintf("UPDATE  `user` SET colour='%s' WHERE id=%s;", $color, $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("UPDATE  `user` SET colour = :color WHERE id = :id;");
    $retval->execute(array('colour' => $color, 'id' => $id));

    if (!$retval) {
      die('Could not update colour: ' . mysql_error());
    }
  }
  function getColour($id){
    global $conn;
    // global $db;
    // $sql = sprintf("SELECT colour FROM user WHERE id=%s;", $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("SELECT colour FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    if (!$retval) {
      die('Could not get colour: ' . mysql_error());
    }

    foreach ($retval as $row) {
      return $row[0];
    }
  }
  function setPrivSnippet($id, $snippet){
    global $conn;
    // global $db;
    // $sql = sprintf("UPDATE  `user` SET privSnippet='%s' WHERE id=%s;", $snippet, $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("UPDATE  `user` SET privSnippet = :snip WHERE id = :id;");
    $retval->execute(array('id' => $id, 'snip' => $snippet));

    if (!$retval) {
      die('Could not update private snippet: ' . mysql_error());
    }
  }
  function getPrivSnippet($id){
    global $conn;
    // global $db;
    // $sql = sprintf("SELECT privSnippet FROM user WHERE id=%s;", $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("SELECT privSnippet FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    if (!$retval) {
      die('Could not get private snippet: ' . mysql_error());
    }

    foreach ($retval as $row) {
      return $row[0];
    }
  }
  function getUserData($userId) {
    global $conn;
    // global $db;
    // $sql = sprintf("SELECT * FROM user WHERE id=%s;", $userID);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn);
    //
    // $retval = $conn->prepare("SELECT privSnippet FROM user WHERE id = :id;");
    // $retval->execute(array('id' => $id));

    $retval = $conn->prepare("SELECT * FROM user WHERE id = :id;");
    $retval->execute(array('id' => $userId));

    if (!$retval) {
        die('Could not get user: ' . mysql_error());
    }

    foreach ($retval as $row) {
      return $row;
    }
  }
  function updateUserData($userId, $username, $password, $icon, $colour, $snippet, $homepage, $admin) {
    global $conn;
    // global $db;
    // $sql = sprintf("UPDATE user SET username='%s', password='%s', colour='%s',icon ='%s', homepage='%s', isAdmin='%s', privSnippet='%s'   WHERE id=%s;" , $username, $password, $colour, $icon, $homepage, $admin, $snippet, $userID);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("UPDATE user SET username = :username, password = :pw, colour = :colour, icon = :icon, homepage = :homepage, isAdmin = :admin, privSnippet = :privSnip   WHERE id = :id;");
    $retval->execute(array('id' => $userId, 'username' => $username, 'pw' => $password, 'colour' => $colour, 'icon' => $icon, 'homepage' => $homepage, 'admin' => $admin, 'privSnip' => $snippet));

    if (!$retval) {
      die('Could not update user: ' . mysql_error());
    }
  }
  function getAllUsers() {
    global $conn;
    // global $db;
    // $sql = sprintf("SELECT * FROM user");
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn);

    $retval = $conn->prepare("SELECT * FROM user");
    $retval->execute();

    if (!$retval) {
      die('Could not get users: ' . mysql_error());
    }

    $arr = array();
    foreach ($retval as $row) {
      array_push($arr, $row);
    }

    return $arr;
  }
  function createSnippet($snippet, $userId){
    global $conn;
    // global $db;
    // $sql = sprintf("INSERT INTO snippet (userId, snippet) VALUES ('%s', '%s');", $userId, $snippet);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("INSERT INTO snippet (userId, snippet) VALUES (:id, :snip);");
    $retval->execute(array('id' => $userId, 'snip' => $snippet));

    if (!$retval) {
      die('Could not create snippet: ' . mysql_error());
    }
  }
  function getPublicSnippet($userId){
    global $conn;
    // global $db;
    // $sql = sprintf("SELECT snippet FROM snippet WHERE userId=%s ORDER BY createdAt DESC", $userId);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn);

    $retval = $conn->prepare("SELECT snippet FROM snippet WHERE userId = :userId ORDER BY createdAt DESC;");
    $retval->execute(array('userId' => $userId));

    if (!$retval) {
      die('Could not get snippets: ' . mysql_error());
    }

    foreach ($retval as $row) {
      return $row[0];
    }
  }
  function deleteSnippet($snippetId, $userId){
      global $conn;
      // global $db;
      // $sql = sprintf("DELETE FROM snippet WHERE id=%s", $snippetId);
      // mysql_select_db($db);
      // $retval = mysql_query( $sql, $conn);

      $retval = $conn->prepare("DELETE FROM snippet WHERE id = :id AND userId = :userId;");
      $retval->execute(array('id' => $snippetId, 'userId' => $userId));

      if (!$retval) {
          die('Invalid query: ' . mysql_error());
      }
  }
  function getAllSnippets($userId){
    global $conn;
    // global $db;
    // $sql = sprintf("SELECT snippet, id FROM snippet WHERE userId=%s ORDER BY createdAt DESC;", $userId);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn);

    $retval = $conn->prepare("SELECT snippet, id FROM snippet WHERE userId = :userId ORDER BY createdAt DESC;");
    $retval->execute(array('userId' => $userId));

    if (!$retval) {
      die('Could not get snippets: ' . mysql_error());
    }

    $arr = array();
    foreach ($retval as $row) {
      array_push($arr, $row);
    }

    return $arr;
  }
  function setIcon($id, $icon){
    global $conn;
    // global $db;
    //
    // $sql = sprintf("UPDATE `user` SET icon='%s' WHERE id=%s;", $icon, $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("UPDATE user SET icon = :icon WHERE id = :id;");
    $retval->execute(array('id' => $id, 'icon' => $icon));

    if (!$retval) {
      die('Could not update icon: ' . mysql_error());
    }
  }
  function getIcon($id){
    global $conn;
    // global $db;
    // $sql = sprintf("SELECT icon FROM user WHERE id=%s;", $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("SELECT icon FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    if (!$retval) {
      die('Could not get icon: ' . mysql_error());
    }

    foreach ($retval as $row) {
      return $row[0];
    }
  }
  function createFile($fileName, $userId){
    global $conn;
    // global $db;
    // $sql = sprintf("INSERT INTO file (userId, fileName) VALUES ('%s', '%s');", $userId, $fileName);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("INSERT INTO file (userId, fileName) VALUES (:id, :fileName);");
    $retval->execute(array('id' => $id, 'fileName' => $fileName));

    if (!$retval) {
      die('Could not create snippet: ' . mysql_error());
    }
  }
  function getAllFiles($userId){
    global $db;
    // global $conn;
    // $sql = sprintf("SELECT fileName, id FROM snippet WHERE userId=%s ORDER BY createdAt DESC", $userId);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn);

    $retval = $conn->prepare("SELECT fileName, id FROM snippet WHERE userId = :id ORDER BY createdAt DESC");
    $retval->execute(array('id' => $userId));

    if (!$retval) {
      die('Could not get files: ' . mysql_error());
    }

    $arr = array();
    foreach ($retval as $row) {
      array_push($arr, $row);
    }

    return $arr;
  }
  function isAdmin($id){
    global $conn;
    // global $db;
    // $sql = sprintf("SELECT isAdmin FROM user WHERE id=%s;", $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("SELECT isAdmin FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    if (!$retval) {
      die('Could not get icon: ' . mysql_error());
    }

    foreach ($retval as $row) {
      return $row['isAdmin'];
    }
  }
  function promoteUser($id){
    global $conn;
    // global $db;
    //
    // $sql = sprintf("UPDATE  `user` SET isAdmin='1' WHERE id=%s;", $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("UPDATE  `user` SET isAdmin='1' WHERE id = :id;");
    $retval->execute(array('id' => $id));

    if (!$retval) {
      die('Could not update icon: ' . mysql_error());
    }
  }
  function unpromoteUser($id){
    global $conn;
    // global $db;
    //
    // $sql = sprintf("UPDATE  `user` SET isAdmin='0' WHERE id=%s;", $id);
    // mysql_select_db($db);
    // $retval = mysql_query( $sql, $conn );

    $retval = $conn->prepare("UPDATE  `user` SET isAdmin='0' WHERE id = :id;");
    $retval->execute(array('id' => $id));

    if (!$retval) {
      die('Could not update icon: ' . mysql_error());
    }
  }

?>
