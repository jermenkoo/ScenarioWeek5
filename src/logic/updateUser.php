<?php
  include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");
  function getData($str) {
      if (isset($_POST[$str])) {
          return $_POST[$str];
      } else { return "" ; }
  }

  try {
    NoCSRF::check( 'csrf_token', $_POST, true, 60*10, false );

    if (SessionManager::isLoggedIn()) {
        $admin = (SessionManager::isAdmin() && getData("admin")) ? 1 : 0;
        $updateID = SessionManager::isAdmin() ? getData('userID') : $_SESSION['userID'];

        if (SessionManager::isAdmin()) {
          $canPost = getData("canPost") == 'on' ? 1 : 0;
        } else {
          $canPost = canUserPost($updateID);
        }

        if (strpos(getData('profileColour'), ";") !== false) {
          header('Location: ' . $URL . '/');
          die();
        }

        updateUserData($updateID, getData('username'), getData('iconURL'), getData('profileColour'), getData('snippet'), getData('homepage'), $admin, $canPost);
        header('Location: ' . $URL . '/');
    }
  } catch (Exception $e) {
    echo 'CSRF detected';
  }


  die();
?>
