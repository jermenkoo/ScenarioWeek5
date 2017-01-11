<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getPost($str) {
    if (isset($_POST[$str])) {
        return $_POST[$str];
    } else { return "" ; }
}

include('../../../db.php');

if(isset($_GET['update']) && $_GET['update']){
    updateUserData(getPost('userID'), getPost('username'), getPost('pw'), getPost('iconURL'), getPost('profileColour'), getPost('snippet'), getPost('homepage'), getPost('admin'));
}

if (isset($_COOKIE['user']) && isset($_COOKIE['pw']) && validCredentials($_COOKIE['user'], $_COOKIE['pw'])[0]) {

    if (isset($_COOKIE['isAdmin']) && $_COOKIE['isAdmin']){
        $isAdmin = True;
        if (isset($_GET['userID'])) {
            $userID = $_GET['userID'];
        } else { die("User doesn't exist"); }
    } else {
        $userID = validCredentials($_COOKIE['user'], $_COOKIE['pw'])[1];
        $isAdmin = False;
    }

    $data = array();
    $data = getUserData($userID);
?>
<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>?update=1" method="POST">
<input type="hidden" name="userID" value="<?php echo $userID; ?>">
Username: <input type="textfield" name="username" value="<?php echo $data['username']; ?>"></br>
Password: <input type="textfield" name="pw" value="<?php echo $data['password']; ?>"></br>
Icon URL <input type="textfield" name="iconURL" value="<?php echo $data['icon']; ?>"></br>
Profile Colour <input type="textfield" name="profileColour" value="<?php echo $data['colour']; ?>"></br>
Private Snipped <input type="textfield" name="snippet" value="<?php echo $data['privSnippet']; ?>"></br>
<?php if ($isAdmin) { ?>
Admin <input type="checkbox" name="admin" <?php if ($data['isAdmin']) { echo "checked"; } ?> ></br>
<?php } else { ?>

<input type="hidden" name="admin" value="<?php echo $data['isAdmin']; ?>">

<?php } ?>
Homepage <input type="textfield" name="homepage" value="<?php echo $data['homepage']; ?>"></br>
<input type="submit">
</form>

<?php
    } else { echo 'please log in'; }
?>