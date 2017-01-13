<div class="nav">
    <?php
    if (isset($_COOKIE['user']) && isset($_COOKIE['pw']) && validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {
        ?>

        <?php
          echo "<a href='/src/view/account/editProfile.php'>";
        ?>
        <div class="user">
        <?php
            $user = $_COOKIE['user'];
            $colour = getColour($_COOKIE['id']) ? getColour($_COOKIE['id']) : "black";
            $colouredUser = sprintf("<span style='color: %s; margin-left: 10px;'>%s</span>", $colour, $user);
            $iconUrl = getIcon($_COOKIE['id']);
            echo "<img class='user-image' src='" . $iconUrl . "' />";
            echo $colouredUser;
        ?>
        </div>
        </a>

        <div class='nav-buttons'>
            <a href='/'><span class='user-button'>Home</span></a>
            <a href='/src/view/snippets.php'><span class='user-button'>Snippets</span></a>
            <a href='/src/view/uploadFile.php'><span class='user-button'>Upload file</span></a>
            <?php
              if ($_COOKIE['isAdmin']) {
                echo "<a href='/src/view/admin.php'><span class='user-button'>Admin panel</span></a>";
              }
            ?>
            <a href="" id="logout">Log out</a>

            <script>
                document.getElementById("logout").addEventListener("click", logOut);

                function logOut() {
                    console.log('Log out');
                    document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });

                    location.reload();
                }

                function delete_cookie(name) {
                    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                }
            </script>
        </div>

        <?php
    } else {
        echo "<div></div>",
            "<div class='nav-buttons'>",
            "<a href='/src/view/account/login.php?url=http://localhost:8080'><span class='user-button'>Log in</span></a>",
            "<a href='/src/view/account/signup.php'><span class='user-button'>Sign up</span></a>",
            "</div>";
    }
    ?>
</div>
