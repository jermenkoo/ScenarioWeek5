<div class="nav">
    <?php 
        if (isset($_GET['username']) && isset($_GET['pw']) && loggedIn($_GET['username'], $_GET['pw'])) {
            echo "<div class='nav-buttons'>",
                $_GET['username'],
                "</div>"; 
        } else {
            echo "<div class='nav-buttons'>",
                "<a href='/src/view/login.php'><span class='nav-button'>Log in</span></a>",
                "<a href='/src/view/signup.php'><span class='nav-button'>Sign up</span></a>",
                "</div>";
        }
    ?>
</div>