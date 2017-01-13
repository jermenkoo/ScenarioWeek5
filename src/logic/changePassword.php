<?php
  include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");

  try {
    NoCSRF::check( 'csrf_token', $_POST, true, 60*10, false );

    if (SessionManager::isLoggedIn()) {
      if (isset($_POST['oldPW']) && isset($_POST['newPW']) && isset($_POST['userID'])) {
        $success;
        if(SessionManager::isAdmin() && ($_SESSION['userID'] != $_POST['userID']) ){
          $success = changePasswordAdmin($_POST['userID'], $_POST['oldPW'], $_POST['newPW']);
        } else {
          $success = changePassword($_POST['userID'], $_POST['oldPW'], $_POST['newPW']);
        }
        if ($success) {
          header('Location: ' . $URL . '/src/view/account/changePW.php?success=');
        } else {
          header('Location: ' . $URL . '/src/view/account/changePW.php?error=' . 'Old password not valid.');
        }
      } else {
        header('Location: ' . $URL . '/src/view/account/changePW.php?error=' . 'Old/new password missing.');
      }
    }
  } catch (Exception $e) {
    echo 'CSRF detected';
    header('Location: ' . $URL . '/src/view/account/changePW.php?error=' . 'CSRF detected.');
  }
?>
