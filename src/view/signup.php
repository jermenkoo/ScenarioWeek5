<html>
    <head>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>

    <?php
    include 'db.php';
    include './header.php';
    // check if the user is logged in
    if (isset($_GET['username']) && isset($_GET['pw']) && validCredentials($_GET['username'], $_GET['pw'])[0]) {
       echo 'hello';
    } else {
        include './forms/signupForm.php';
    }
    ?>
    </body>
</html>
