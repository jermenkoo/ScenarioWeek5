<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
    
    <?php
    include '../../db.php';
    include './header.php';
    // check if the user is logged in
    if (isset($_GET['username']) && isset($_GET['pw']) && loggedIn($_GET['username'], $_GET['pw'])) {
        header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
        die();
    } else {
        echo '<center>';
        include './forms/loginForm.php';
        echo '</center>';
    }
    ?>
    </body>
</html>
