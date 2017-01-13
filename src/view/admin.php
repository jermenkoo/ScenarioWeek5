<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
        <script type="text/javascript" src="/src/dompurify/purify.js"></script>
    </head>
    <body>
      <?php
        include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");
        error_reporting(0);

        // Not logged in
        if (!SessionManager::isAdmin()) {
            header('Location: ' . $URL . '/index.php');
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
