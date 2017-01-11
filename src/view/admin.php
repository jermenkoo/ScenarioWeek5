<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
      <?php
        include '../../db.php';
        include './header.php';

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Not logged in
        if (!isset($_COOKIE['user']) or !isset($_COOKIE['pw']) or !$_COOKIE['isAdmin']
          or !validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {
            header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
            die();
        } else {
          ?>
          <div class="user-list">

          <?php

          $users = getAllUsers();
          foreach ($users as $user){
              $username = $user['username'];
              $colour = getColour($user['id']) ? getColour($user['id']) : "black";
              $colouredUser = sprintf("<span style='color: %s'>%s</span>", $colour, $username);
          ?>
              <div class="user-container">
                <?php echo $colouredUser ?>
                <div><a href="/src/view/account/editProfile.php?userID=<?php echo $user['id']; ?>">Profile</a></div>
              </div>
            <?php
          }
       }
    ?>
      </div>
    </body>
</html>
