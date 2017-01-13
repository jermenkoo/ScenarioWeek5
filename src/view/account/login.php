<html>
    <head>
        <link rel="stylesheet" href="../../styles/style.css">
    </head>
    <body>

    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");

    if (isset($_GET['error'])) {
      echo $_GET['error'];
    }

    echo '<center>';
    include '../forms/loginForm.php';
    echo '</center>';

    if (isset($_POST['username']) && isset($_POST['password'])){
        $valid = validCredentials($_POST['username'], $_POST['password']);
        $isAdmin = (bool) $valid[2];
        $userID  = $valid[1];
        $valid   = $valid[0];

        if ($valid == true) {
            // clear the $_POST just in case
            $_POST = array();
            $_SESSION['userID'] = $userID;
            $_SESSION['isAdmin'] = $isAdmin;
            header('Location: ' . $URL . '/index.php');
        } elseif ($userID == 2) {
          ?>
          <center>
            Log in blocked. Too many attempts.
          </center>
          <?php
        } else {
          ?>
          <center>
            Wrong user name or password.
          </center>
          <?php
        }
    }

    ?>
    </body>
</html>
