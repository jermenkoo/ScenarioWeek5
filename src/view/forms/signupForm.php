<?php
include('../../db.php');
include('../header.php');

    if (!isset($_GET['username']) || (!isset($_GET['password']) )){ ?>
        <h2> Register </h2>
        <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="get">
            User Name </br>
            <input type="text" name="username"></br>
            Password </br>
            <input type="password" name="password"></br>
            <input type="submit" value="Sign up">
        </form>
<?php
    }
    else {
        createUser($_GET['username'], $_GET['password']);
        echo '<h2> Registered! </h2>';
        echo 'You can log in now!';
    }
?>



