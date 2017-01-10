<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
    
    <?php
    include '../../db.php';
    include './header.php';
    
    // Log in user
    if (isset($_POST['username']) && isset($_POST['pw'])) {
        if (validCredentials($_POST['username'], $_POST['pw'])) {
            setcookie("user", $_POST['username'], time() + (86400 * 30), '/');
            setcookie("pw", $_POST['pw'], time() + (86400 * 30), '/');
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
    ?>
    </body>
</html>
