<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (SessionManager::isLoggedIn() && isset($_GET['userID'])) {
    if ($_SESSION['userID'] == $_GET['userID'] || SessionManager::isAdmin()){
        $data = array();
        $data = getUserData($_GET['userID']);
    } else {
        die("ILLEGAL REQUEST");
    }

    $token = NoCSRF::generate( 'csrf_token' );
?>
<form class="file-upload" action="<?php echo $URL; ?>/src/logic/changePassword.php" method="POST">
  <input type="hidden" name="userID" value="<?php echo $_GET['userID']; ?>" >
  Old password: <input type="password" name="oldPW"></br>
  New password: <input type="password" name="newPW"></br>
  <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
  <input value="Save" type="submit">
</form>

<?php
    } elseif (!SessionManager::isLoggedIn()) {
      header('Location: ' . $URL . '/src/view/account/changePW.php?success=');
    }
?>
