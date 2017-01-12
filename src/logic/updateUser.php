<?php
  include '../../db.php';

  function getData($str) {
      if (isset($_GET[$str])) {
          return $_GET[$str];
      } else { return "" ; }
  }

  if(isset($_GET['username']) && isset($_COOKIE['id']) && validCredentials($_COOKIE['user'], $_COOKIE['pw'])){
      $admin = getData('admin') == "on" ? 1 : 0;
      updateUserData($_COOKIE['id'], getData('username'), getData('iconURL'), getData('profileColour'), getData('snippet'), getData('homepage'), $admin);;
  }

  header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/');
  die();
?>
