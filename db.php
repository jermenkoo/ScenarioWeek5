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

    $retval = $conn->prepare("SELECT password, id, isAdmin FROM user WHERE username = :name;");
    $retval->execute(array('name' => $username));

    foreach ($retval as $row) {
      if (password_verify($password, $row['password'])) {
        return [true, $row['id'], $row['isAdmin']];
      } else {
        return [false, -1, -1];
      }
    }
  }

  function validCredentialsId($id, $password){
    global $conn;

    $retval = $conn->prepare("SELECT password FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    foreach ($retval as $row) {
      if (password_verify($password, $row['password'])) {
        echo $row;
        return True;
      } else {
        return False;
      }
    }
  }

  function createUser($username, $password){
    global $conn;

    $retval = $conn->prepare("INSERT INTO user (username, password, isAdmin) VALUES (:username, :password, 0);");
    $retval->execute(array('username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT)));
  }

  function setColour($id, $color){
    global $conn;

    $retval = $conn->prepare("UPDATE  `user` SET colour = :color WHERE id = :id;");
    $retval->execute(array('colour' => $color, 'id' => $id));
  }

  function getColour($id){
    global $conn;

    $retval = $conn->prepare("SELECT colour FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    foreach ($retval as $row) {
      return $row[0];
    }
  }

  function setPrivSnippet($id, $snippet){
    global $conn;

    $retval = $conn->prepare("UPDATE  `user` SET privSnippet = :snip WHERE id = :id;");
    $retval->execute(array('id' => $id, 'snip' => $snippet));
  }

  function getPrivSnippet($id){
    global $conn;

    $retval = $conn->prepare("SELECT privSnippet FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    foreach ($retval as $row) {
      return $row[0];
    }
  }

  function getUserData($userId) {
    global $conn;

    $retval = $conn->prepare("SELECT id, username, colour, icon, privSnippet, isAdmin, homepage, canPost FROM user WHERE id = :id;");
    $retval->execute(array('id' => $userId));

    foreach ($retval as $row) {
      return $row;
    }
  }

  function updateUserData($userId, $username, $icon, $colour, $snippet, $homepage, $admin, $canPost) {
    global $conn;

    $retval = $conn->prepare("UPDATE user SET username = :username, colour = :colour, icon = :icon, homepage = :homepage, isAdmin = :admin, privSnippet = :privSnip, canPost = :canPost   WHERE id = :id;");
    $retval->execute(array('id' => $userId, 'username' => $username, 'colour' => $colour, 'icon' => $icon, 'homepage' => $homepage, 'admin' => $admin, 'privSnip' => $snippet, 'canPost' => $canPost));
  }


  function changePassword($userId, $oldPW, $newPW) {
    global $conn;

    if (validCredentialsId($userId, $oldPW)) {
      $retval = $conn->prepare("UPDATE user SET password = :newPW  WHERE id = :id;");
      $retval->execute(array('id' => $userId, 'newPW' => password_hash($newPW, PASSWORD_DEFAULT)));

      return True;
    } else {
      return False;
    }
  }

  function changePasswordAdmin($userId, $newPW) {
    global $conn;

    $retval = $conn->prepare("UPDATE user SET password = :newPW  WHERE id = :id;");
    $retval->execute(array('id' => $userId, 'newPW' => md5($newPW)));

    echo var_dump($retval);

    foreach ($retval as $row) {
      return True;
    }

    return False;
  }

  function getUserName($userID){
    global $conn;
    $retval = $conn->prepare("SELECT username FROM user WHERE id=:userID;");
    $retval->execute(array('userID' => $userID));

    foreach ($retval as $row) {
      return $row[0];
    }
  }

  function getAllUsers() {
    global $conn;

    $retval = $conn->prepare("SELECT * FROM user");
    $retval->execute();

    $arr = array();
    foreach ($retval as $row) {
      array_push($arr, $row);
    }

    return $arr;
  }

  function createSnippet($snippet, $userId){
    global $conn;

    $retval = $conn->prepare("INSERT INTO snippet (userId, snippet) VALUES (:id, :snip);");
    $retval->execute(array('id' => $userId, 'snip' => $snippet));
  }

  function getPublicSnippet($userId){
    global $conn;

    $retval = $conn->prepare("SELECT snippet FROM snippet WHERE userId = :userId ORDER BY createdAt DESC;");
    $retval->execute(array('userId' => $userId));

    foreach ($retval as $row) {
      return $row[0];
    }
  }

  function deleteSnippet($snippetId, $userId){
      global $conn;

      $retval = $conn->prepare("DELETE FROM snippet WHERE id = :id AND userId = :userId;");
      $retval->execute(array('id' => $snippetId, 'userId' => $userId));
  }

  function getAllSnippets($userId){
    global $conn;

    $retval = $conn->prepare("SELECT snippet, id FROM snippet WHERE userId = :userId ORDER BY createdAt DESC;");
    $retval->execute(array('userId' => $userId));

    $arr = array();
    foreach ($retval as $row) {
      array_push($arr, $row);
    }

    return $arr;
  }

  function setIcon($id, $icon){
    global $conn;

    $retval = $conn->prepare("UPDATE user SET icon = :icon WHERE id = :id;");
    $retval->execute(array('id' => $id, 'icon' => $icon));
  }

  function getIcon($id){
    global $conn;

    $retval = $conn->prepare("SELECT icon FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    foreach ($retval as $row) {
      return $row[0];
    }
  }

  function createFile($fileName, $userId){
    global $conn;

    $retval = $conn->prepare("INSERT INTO file (userId, fileName) VALUES (:id, :fileName);");
    $retval->execute(array('id' => $id, 'fileName' => $fileName));
  }

  function getAllFiles($userId){
    global $db;

    $retval = $conn->prepare("SELECT fileName, id FROM snippet WHERE userId = :id ORDER BY createdAt DESC");
    $retval->execute(array('id' => $userId));

    $arr = array();
    foreach ($retval as $row) {
      array_push($arr, $row);
    }

    return $arr;
  }

  function canUserPost($id){
    global $conn;

    $retval = $conn->prepare("SELECT canPost FROM user WHERE id = :id;");
    $retval->execute(array('id' => $id));

    foreach ($retval as $row) {
      return $row['canPost'];
    }
  }
?>
