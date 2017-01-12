<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (SessionManager::isLoggedIn()) {
    $data = array();
    $data = getUserData($_SESSION['userID']);
    // if wanna check if current logged in user is an admin:
    // SessionManager::isAdmin()
?>
<form action="/src/logic/updateUser.php" method="GET">
Username: <input type="textfield" name="username" value="<?php echo $data['username']; ?>"></br>
Password: <input type="textfield" name="pw" value="<?php echo $data['password']; ?>"></br>
Icon URL <input type="textfield" name="iconURL" value="<?php echo $data['icon']; ?>"></br>
Profile Colour <input type="textfield" name="profileColour" value="<?php echo $data['colour']; ?>"></br>
Private Snippet <input type="textfield" name="snippet" value="<?php echo $data['privSnippet']; ?>"></br>
<?php if ($isAdmin) { ?>
Admin <input type="checkbox" name="admin" <?php if ($data['isAdmin']) { echo "checked"; } ?> ></br>
<?php } ?>

Homepage <input type="textfield" name="homepage" value="<?php echo $data['homepage']; ?>"></br>
<input value="Save" type="submit">
</form>

<?php
    } else { echo 'please log in'; }
?>
