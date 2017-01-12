<html>
    <head>
        <link rel="stylesheet" href="../../styles/style.css">
        <script type="text/javascript" src="/src/dompurify/purify.js"></script>
    </head>
    <body>
    <?php
    include ($_SERVER['DOCUMENT_ROOT'] . "/src/view/header.php");
    if (isset($_GET['success'])) {
        echo '<h1> password successfully changed </h1>';
    } else {
        if(isset($_GET['error'])){
            echo '<h1>' . $_GET['error'] . '</h1>';
        }
        include($_SERVER['DOCUMENT_ROOT'] . "/src/view/forms/passwordForm.php");
    }
    
    ?>
    </body>
</html>