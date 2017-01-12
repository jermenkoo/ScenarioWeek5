<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
      <?php
        include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Not logged in
        if (!SessionManager::isLoggedIn()) {
            header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/index.php');
            die();
        }
        ?>

        <form class="file-upload" action="
        <?php echo $URL; ?>/src/logic/upload.php" method="POST" enctype="multipart/form-data">
            <?php
            if (isset($_GET['url'])) {
              $host = $URL . '/';
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
