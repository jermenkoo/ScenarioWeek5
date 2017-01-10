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
            ?>

            <div>
                <div class="snippet-form">
                    <textarea name="snippet" form="snippet">Enter your snippet</textarea>
                    <form action="../logic/createSnippet.php" id="snippet" method="post">
                        <input value="Create" type="submit">
                    </form>
                </div>
            </div>

            <div class="snippet-list">
            <?php
            $snippets = getAllSnippets($_COOKIE['id']);

            foreach ($snippets as $snippet) {
               echo "<div class='snippet-container'>";
               echo $snippet;
               echo "</div>";
            }

            echo "</div>";      
       }
    ?>
    </body>
</html>
