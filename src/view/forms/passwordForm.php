<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (SessionManager::isLoggedIn()) {
    $data = array();
    $data = getUserData($_SESSION['userID']);
?>
<form action="/src/logic/changePassword.php" method="GET">
Old password: <input type="textfield" name="oldPw" value="<?php echo $data['username']; ?>"></br>
New password: <input type="textfield" name="newPw" value="<?php echo $data['password']; ?>"></br>

<input value="Save" type="submit">
</form>

<?php
    } else { echo 'please log in'; }
?>
