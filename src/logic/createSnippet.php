<?php
    include "../../db.php";

    if (isset($_POST["snippet"])) {
        echo "post request";
        createSnippet($_POST["snippet"], $_COOKIE["id"]);
        header('Location: ' . 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/src/view/snippets.php');
    }
?>

