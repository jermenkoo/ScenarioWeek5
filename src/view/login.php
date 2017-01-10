<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>

    <?php
    include '../../db.php';
    include './header.php';

    if (isset($_COOKIE['user']) && isset($_COOKIE['pw'])) {
        if (validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {
            header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
        } else {
            echo 'Invalid username or password';
        }
        die();
    } elseif (isset($_POST['username']) && isset($_POST['pw'])) {
        $valid = validCredentials($_POST['username'], $_POST['pw']);
        if ($valid[0]) {
            setcookie("user", $_POST['username'], time() + (86400 * 30), '/');
            setcookie("pw", $_POST['pw'], time() + (86400 * 30), '/');
            setcookie("id", $valid[1], time() + (86400 * 30), '/');
            header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
        } else {
            echo 'Invalid username or password';
        }
        die();
    } else {
        echo '<center>';
        include './forms/loginForm.php';
        echo '</center>';
    }
    // Log in user
    ?>
    </body>
</html>
