<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);
?>

<html>
    <head>
        <link rel="stylesheet" href="./src/styles/style.css">
        <script type="text/javascript" src="/src/dompurify/purify.js"></script>
    </head>
    <body>

    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");
    // check whether the use wants to log out, if yes, destroy session
        include 'src/view/publicUsersTable.php';
    echo '<pre>';
    echo '</pre>';
    ?></body>
</html>
