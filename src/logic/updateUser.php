<?php
  include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");
  function getData($str) {
      if (isset($_POST[$str])) {
          return $_POST[$str];
      } else { return "" ; }
  }

  echo var_dump($_POST);

  if(SessionManager::isLoggedIn()){
      $admin = (SessionManager::isAdmin() && getData("admin"))? 1 : 0;
      $canPost = getData("canPost") == 'on' ? 1 : 0;
      $updateID = SessionManager::isAdmin() ? getData('userID') : $_SESSION['userID'];
      updateUserData($updateID, getData('username'), getData('iconURL'), getData('profileColour'), getData('snippet'), getData('homepage'), $admin, $canPost);;
  }

  header('Location: ' . $URL . '/');
  die();
?>
