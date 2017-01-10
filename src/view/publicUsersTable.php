<center>
<table>
<?php
$users = getAllUsers();
       foreach ($users as $user){
           echo '<tr>';
           echo '<td>' . $user['username'] . '</td><td>' . $user['id'] . '</td><td>' . $user['snippet'] . '</td>';
           echo '</tr>';
       }
?>
</table></center>