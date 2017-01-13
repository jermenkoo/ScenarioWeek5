<?php
error_reporting(0);
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
        /*
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
        */
    ?>

    </body>
</html>
