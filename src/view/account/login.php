<html>
    <head>
        <link rel="stylesheet" href="../../styles/style.css">
    </head>
    <body>

    <?php
    include '../../../db.php';
    include '../header.php';

    // User already logged in
    if (isset($_COOKIE['user']) && isset($_COOKIE['pw'])) {
        if (validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {
          if ($_GET['url']) {
            header('Location: ' . $_GET['url']);
          } else {
            header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
          }
        } else { // Cookies not valid anymore
            setcookie("user", "", time() - 3600);
            setcookie("pw", "", time() - 3600);
            setcookie("id", "", time() - 3600);
            header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/src/view/account/login.php');
        }
        die();
    } elseif (isset($_POST['username']) && isset($_POST['pw'])) { // Log in post request
        $valid = validCredentials($_POST['username'], $_POST['pw']);
        if ($valid[0]) {
            setcookie("user", $_POST['username'], time() + (86400 * 30), '/');
            setcookie("pw", $_POST['pw'], time() + (86400 * 30), '/');
            setcookie("id", $valid[1], time() + (86400 * 30), '/');
            setcookie("isAdmin", $valid[2], time() + (86400 * 30), '/');
            echo "isadmin" . $valid[2];
            header('Location: ' . $_POST['next']);
            //header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/src/view/account/login.php?url=http://localhost:8080/index.php');
            // header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
        } else {
            echo '<center>';
            include '../forms/loginForm.php';
            echo '</center>';
            echo 'Invalid username or password';
        }
        die();
    } else { // Not logged in
        echo '<center>';
        include '../forms/loginForm.php';
        echo '</center>';
    }
    ?>
    </body>
</html>
