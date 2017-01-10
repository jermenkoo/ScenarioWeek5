<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);
?>

<html>
    <head>
        <link rel="stylesheet" href="./src/styles/style.css">
    </head>
    <body>

    <?php
    include 'db.php';
    include 'src/view/header.php';
    // check if the user is logged in
    if (isset($_GET['username']) && isset($_GET['pw']) && loggedIn($_GET['username'], $_GET['pw'])) {
       echo 'hello';
    } else {
       include 'src/view/publicUsersTable.php';
    }
    ?>
    </body>
</html>
