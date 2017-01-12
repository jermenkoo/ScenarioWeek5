<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);
?>
<html>
    <head>
        <link rel="stylesheet" href="../../styles/style.css">
    </head>
    <body>

    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/db.php');
    include '../header.php';
    if (isset($_POST['username']) && isset($_POST['password'])){
        $valid = validCredentials($_POST['username'], $_POST['password']);
        $isAdmin = (bool) $valid[2];
        $userID  = $valid[1];
        $valid   = $valid[0];
        if ($valid){
            // clear the $_POST just in case
            $_POST = array();
            $_SESSION['userID'] = $userID;
            $_SESSION['isAdmin'] = $isAdmin;
        }
    } else {
        include '../forms/loginForm.php';
    }


    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';
    ?>
    </body>
</html>
