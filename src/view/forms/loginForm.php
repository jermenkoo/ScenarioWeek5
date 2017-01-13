<div class="account-form">
  <h2>Log in</h2>
  <form action="/src/view/account/login.php" method="post">
      Login Name </br>
      <input type="text" name="username"></br>
      Password </br>
      <input type="password" name="pw"></br>
      <input type="hidden" name="next" value=<?php echo $_GET['url']?> >
      <input type="submit" value="Log in">
  </form>
</div>
