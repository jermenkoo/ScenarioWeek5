<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
    
    <?php
    include 'db.php';
    include './header.php';
    // check if the user is logged in
    if ( isset($_GET['username']) && isset($_GET['pw']) && loggedIn($_GET['username'], $_GET['pw'])) {
       echo 'hello';
    } else {
        echo '<center>';
        include './loginForm.php';
        echo '</center>';
    }
    ?>
    </body>
</html>
