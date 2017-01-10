<center>
<table>
<?php
$users = getAllUsers();
       foreach ($users as $user){
           $snippet = getPublicSnippet($user['id']);
           if ($snippet == NULL) {
               $snippet = "No snippet";
           }
           echo '<tr>';
           echo '<td>' . $user['username'] . '</td><td>' . $user['id'] . '</td><td>' . $snippet . '</td>';
           echo '</tr>';
       }
?>
</table></center>