<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (SessionManager::isLoggedIn()) {
    $data = array();
    $data = getUserData($_SESSION['userID']);
?>
<form action="<?php echo $URL; ?>/src/logic/changePassword.php" method="POST">
<input type="hidden" name="userID">
Old password: <input type="password" name="oldPW"></br>
New password: <input type="password" name="newPW"></br>
<input value="Save" type="submit">
</form>

<?php
    } else { echo 'please log in'; }
?>
