<html>
    <head>
        <link rel="stylesheet" href="../../styles/style.css">
        <script type="text/javascript" src="/src/dompurify/purify.js"></script>
    </head>
    <body>

    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");

    // User already logged in
    if (SessionManager::isLoggedIn()) {
      echo "<div class='file-upload'>";
      include '../forms/editProfileForm.php';
      echo "</div>";
    } else {
      header('Location: ' . $URL . '/index.php');
    }
    ?>
    </body>
</html>
