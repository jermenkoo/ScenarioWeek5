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

    // User is logged in
    if (isset($_COOKIE['user']) && isset($_COOKIE['pw']) && validCredentials($_COOKIE['user'], $_COOKIE['user'])) {
        include 'src/view/publicUsersTable.php';
    } else {
        include 'src/view/publicUsersTable.php';
    }
    ?>
    </body>
</html>
