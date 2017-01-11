<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
      <?php
        include '../../db.php';
        include './header.php';

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Not logged in
        if (!isset($_COOKIE['user']) or !isset($_COOKIE['pw']) or !validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {
            header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
            die();
        }
        ?>

        <form class="file-upload" action="../logic/upload.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['url'])) {
              $host = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/';
              echo "<div>Your file is available here: " . $host . $_GET['url'] . "</div>";
              echo "<br>";
            } elseif (isset($_GET['error'])) {
              echo "<div>" . $_GET['error'] . "</div>";
              echo "<br>";
            }
            ?>

            Select file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload file" name="submit">
        </form>
    </body>
</html>
