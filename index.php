<html>
    <head>
        <link rel="stylesheet" href="./src/styles/style.css">
    </head>
    <body>
    
    <?php
    include 'db.php';
    include 'src/view/header.php';
    // check if the user is logged in
    if ( isset($_GET['username']) && isset($_GET['pw']) && loggedIn($_GET['username'], $_GET['pw'])) {
       echo 'hello';
    } else {
        echo '<center>';
        include 'src/view/loginForm.php';
        echo '</center>';
    }

    
    ?>
    </body>
</html>
