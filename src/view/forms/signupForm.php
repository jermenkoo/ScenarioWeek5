<?php
include('../../db.php');
    if (!isset($_GET['username']) || (!isset($_GET['password']) )){ ?>
        <div class="account-form">
          <h2>Sign up</h2>
          <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="get">
              User Name </br>
              <input type="text" name="username"></br>
              Password </br>
              <input type="password" name="password"></br>
              <input type="submit" value="Sign up">
          </form>
        </div>
<?php
    }
    else {
        createUser($_GET['username'], $_GET['password']);
        echo '<h2> Registered! </h2>';
        echo 'You can log in now!';
    }
?>
