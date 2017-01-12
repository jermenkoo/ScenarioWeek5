<div class="nav">
    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/src/logic/sessions.php");
    include ($_SERVER['DOCUMENT_ROOT'] . "/db.php");
    SessionManager::sessionStart("user");
    
    if (isset($_GET['logout'])){
        echo 'issset';
        $_SESSION = array();
        session_destroy();
    }
    if (SessionManager::isLoggedIn()) {
          echo "<a href='/src/view/account/editProfile.php'>";
        ?>
        <div class="user">
        <?php
            $user = $_SESSION['userID'];
            $colour = SessionManager::isLoggedIn() ? getColour($_SESSION['userID']) : "black";
            $colouredUser = sprintf("<span style='color: %s; margin-left: 10px;'>%s</span>", $colour, $user);
            $iconUrl = getIcon($_SESSION['userID']);
            echo "<img class='user-image' src='" . $iconUrl . "' />";

            ?>
            <script type="text/javascript">
              var user = "<?php echo $colouredUser; ?>";
              document.write(DOMPurify.sanitize(user));
            </script>
        </div>
        </a>

        <div class='nav-buttons'>
            <a href='/'><span class='user-button'>Home</span></a>
            <a href='/src/view/snippets.php'><span class='user-button'>Snippets</span></a>
            <a href='/src/view/uploadFile.php'><span class='user-button'>Upload file</span></a>
            <?php
              if ($_SESSION['isAdmin']) {
                echo "<a href='/src/view/admin.php'><span class='user-button'>Admin panel</span></a>";
              }
            ?>
            <a href="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . ':' 
                   . $_SERVER['SERVER_PORT'] . '/index.php?logout='; ?>">Log out</a>
        </div>

        <?php
    } else { ?>
        <div></div>
            <div class='nav-buttons'>
            <a href='/src/view/account/login.php'><span class='user-button'>Log in</span></a>
            <a href='/src/view/account/signup.php'><span class='user-button'>Sign up</span></a>
            </div>
    <?php 
    }
    ?>
</div>
