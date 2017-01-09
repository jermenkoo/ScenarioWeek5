<?php 
function loginForm($path) { ob_start(); ?>
<form> 
    Login Name </br>
    <input type="text" name="login"></br>
    Password </br>
    <input type="password" name="password"></br>
    <input type="submit" value="Login!">
</form>

<?php 
    return ob_get_clean(); }
?>