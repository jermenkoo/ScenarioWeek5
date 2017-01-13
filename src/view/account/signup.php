<html>
    <head>
        <link rel="stylesheet" href="../../styles/style.css">
    </head>
    <body>

    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");

    if (isset($_COOKIE['user']) && isset($_COOKIE['pw'])) {
        // User already logged in
        if (validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {
            header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
        } else { // Invalid credentials
            setcookie("user", "", time() - 3600);
            setcookie("pw", "", time() - 3600);
            setcookie("id", "", time() - 3600);
            header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/src/view/account/login.php');
        }
        die();
    } else {
        echo '<center>';
        include '../forms/signupForm.php';
        echo '</center>';
    }
    ?>
    </body>
</html>
