<div class="nav">
    <?php
    if (isset($_COOKIE['user']) && isset($_COOKIE['pw']) && validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {
        echo "<div class='nav-buttons'>",
            "<a href='/'><span class='user-button'>Home</span></a>",
            "<a href='/src/view/snippets.php'><span class='user-button'>Snippets</span></a>",
            "<a href='/src/view/uploadFile.php'><span class='user-button'>Upload file</span></a>",
            $_COOKIE['user'],
            "</div>";
    } else {
        echo "<div class='nav-buttons'>",
            "<a href='/src/view/account/login.php'><span class='user-button'>Log in</span></a>",
            "<a href='/src/view/account/signup.php'><span class='user-button'>Sign up</span></a>",
            "</div>";
    }
    ?>
</div>
