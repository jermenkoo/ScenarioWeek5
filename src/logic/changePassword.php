<?php
  include '../../db.php';

  if (isset($_POST['oldPw']) && isset($_POST['newPW'])) {
    changePassword(_SESSION['userID'], $_POST['oldPw'], $_POST['newPw']);
  } else {

  }
?>
