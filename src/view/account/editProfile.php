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
      echo "<div class='file-upload'>";
      include '../forms/editProfileForm.php';
      echo "</div>";
    } else {
      header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
    }
    ?>
    </body>
</html>
