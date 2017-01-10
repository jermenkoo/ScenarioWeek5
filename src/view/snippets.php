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
        } else {
            include './forms/snippetForm.php';
            
            echo "<div>";

            $snippets = getAllSnippets($_COOKIE['id']);

           foreach ($snippets as $snippet) {
               echo "<div>";
               echo $snippet;
               echo "</div>";
           }
           

           
       }
    ?>
    </body>
</html>
