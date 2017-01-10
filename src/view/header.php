<div class="nav">
    <?php
    if (isset($_COOKIE['user']) && isset($_COOKIE['pw']) && validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {
        ?>

        <div class='nav-buttons'>
            <a href='/'><span class='user-button'>Home</span></a>
            <a href='/src/view/snippets.php'><span class='user-button'>Snippets</span></a>
            <a href='/src/view/uploadFile.php'><span class='user-button'>Upload file</span></a>
            <span id="logout">Log out</p>

            <script>
                document.getElementById("logout").addEventListener("click", logOut);

                function logOut() {
                    delete_cookie('user');
                    delete_cookie('pw');
                    delete_cookie('id');
                    location.reload();
                }

                function delete_cookie(name) {
                    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                }
            </script>

            <?php 
                echo $_COOKIE['user'];
            ?>
        </div>

        <?php
    } else {
        echo "<div class='nav-buttons'>",
            "<a href='/src/view/account/login.php'><span class='user-button'>Log in</span></a>",
            "<a href='/src/view/account/signup.php'><span class='user-button'>Sign up</span></a>",
            "</div>";
    }
    ?>
</div>
