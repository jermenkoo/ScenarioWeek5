<?php
error_reporting(0);
?>
<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
        <script type="text/javascript" src="/src/dompurify/purify.js"></script>
    </head>
    <body>
      <?php
        include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");
        // Other users snippets
        if (isset($_GET['userId'])) {
            ?>
            <div class="snippet-list">
              <div class="title">All snippets for user <?php echo $_GET['userName']; ?>:</div>
            <?php
            $snippets = getAllSnippets($_GET['userId']);
            foreach ($snippets as $snippet) { ?>
               <div class="snippet-container">
                   <script type="text/javascript">
                     var snip = "<?php echo $snippet['snippet'] ?>";
                     document.write(DOMPurify.sanitize(snip));
                   </script>
              </div>
            <?php
            }
            echo "</div>";

        }
        // Not logged in
        elseif (!SessionManager::isLoggedIn()) {
            header('Location: ' . 'https://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
            die();
        // Not allowed
        } elseif (!canUserPost($_SESSION['userID'])){
          header('Location: ' . 'https://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/index.php');
          die();
        } else {
            if (isset($_POST["snippet"])) {
              try {
                NoCSRF::check('csrf_token', $_POST, true, 60*10, false);

                createSnippet($_POST["snippet"], $_SESSION['userID']);
              } catch (Exception $e) {
                echo 'CSRF detected';
              }
            } else if (isset($_GET['delete'])){
                deleteSnippet($_GET['delete'], $_SESSION['userID']);
            }
          ?>

          <?php $token = NoCSRF::generate('csrf_token'); ?>

            <div>
                <div class="snippet-form">
                    <textarea name="snippet" form="snippet">Enter your snippet</textarea>
                    <form class="snippet-form" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" id="snippet" method="POST">
                      <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                      <input value="Create" type="submit">
                    </form>
                </div>
            </div>

            <div class="snippet-list">
            <?php
            $snippets = getAllSnippets($_SESSION['userID']);
            foreach ($snippets as $snippet) { ?>
              <div class="snippet-container">
               <script type="text/javascript">
                 var snip = "<?php echo $snippet['snippet'] ?>";
                 document.write(DOMPurify.sanitize(snip));
               </script>
               <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?delete=<?php echo $snippet['id']; ?>">Delete</a>
             </div>
            <?php
            }
            echo "</div>";
       }
    ?>
    </body>
</html>
