<?php
error_reporting(0);

if (SessionManager::isLoggedIn()) {
    $data = array();
    // let us see if we are an admin
    if (SessionManager::isAdmin()){
        if (isset($_GET['userID'])){
            $data = getUserData($_GET['userID']);
        } else  {
            $data = getUserData($_SESSION['userID']);
        }
    } else {
        $data = getUserData($_SESSION['userID']);
    }

    $token = NoCSRF::generate( 'csrf_token' );
?>
<form action="<?php echo $URL; ?>/src/logic/updateUser.php" method="POST">
  <input type="hidden" name="userID" value="<?php echo $data['id']; ?>">
  Username: <input type="textfield" name="username" value="<?php echo $data['username']; ?>"></br>
  Icon URL <input type="textfield" name="iconURL" value="<?php echo $data['icon']; ?>"></br>
  Profile Colour <input type="textfield" name="profileColour" value="<?php echo $data['colour']; ?>"></br>
  Private Snippet <input type="textfield" name="snippet" value="<?php echo $data['privSnippet']; ?>"></br>
  Homepage <input type="textfield" name="homepage" value="<?php echo $data['homepage']; ?>"></br>

  <?php if (SessionManager::isAdmin()) { ?>
      Admin <input type="checkbox" name="admin" <?php if ($data['isAdmin']) { echo "checked"; } ?> ></br>
      Can create snippets <input type="checkbox" name="canPost" <?php if ($data['canPost']) { echo "checked"; } ?> ></br>
  <?php } ?>

  <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

  <input value="Save" type="submit">
</form>
<a href="<?php echo $URL; ?>/src/view/account/changePW.php?userID=<?php echo $data['id']; ?>"> Change Password </a>

<?php
    } else { echo 'please log in'; }
?>
