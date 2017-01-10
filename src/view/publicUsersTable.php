<div class="snippet-list">
    <?php
        $users = getAllUsers();
        foreach ($users as $user){
            $snippet = getPublicSnippet($user['id']);
            if ($snippet == NULL) {
                $snippet = "No snippet";
            }
            echo '<div class="snippet-container">';
            echo '<div>' . $user['username'] . '</div><div>' . $snippet . '</div>';
            echo '</div>';
        }
    ?>
</div>