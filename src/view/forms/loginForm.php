<div class="account-form">
  <h2>Log in</h2>
  <div class="account-form">
    <form action="
    <?php echo 'https://' . $_SERVER['SERVER_NAME'] . ':'
                     . $_SERVER['SERVER_PORT'] . '/src/view/account/login.php" method="post">';
        ?>
        Username </br>
        <input type="text" name="username"></br>
        Password </br>
        <input type="password" name="password"></br>
        <input type="submit" value="Log in">
    </form>
  </div>
</div>
