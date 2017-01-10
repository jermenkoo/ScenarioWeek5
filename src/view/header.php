<div class="nav">
    <?php 
        if (isset($_GET['username']) && isset($_GET['pw']) && loggedIn($_GET['username'], $_GET['pw'])) {
            echo "<div class='nav-buttons'>",
                "<a href='/src/view/uploadFile.php'><span class='user-button'>Upload file</span></a>",
                $_GET['username'],
                "</div>"; 
        } else {
            echo "<div class='nav-buttons'>",
                "<a href='/src/view/login.php'><span class='user-button'>Log in</span></a>",
                "<a href='/src/view/signup.php'><span class='user-button'>Sign up</span></a>",
                "</div>";
        }
    ?>
</div>