<div class="snippet-list">
    <?php
        $users = getAllUsers();
        foreach ($users as $user){
            $username = $user['username'];
            $colour = getColour($user['id']) ? getColour($user['id']) : "black";
            $colouredUser = sprintf("<span style='color: %s'>%s</span>", $colour, $username);
            $snippet = getPublicSnippet($user['id']);
            if ($snippet == NULL) {
                $snippet = "No snippet";
            }
            echo '<div class="snippet-container">';
            $iconUrl = getIcon($user['id']);
            echo '<div class="user">';
            echo "<img class='user-image' src='" . $iconUrl . "' />";
            echo '<span class="user-label">' . $colouredUser . '</span>'
            . '<a href="/src/view/snippets.php?userId=' . $user['id'] . "&userName=" . $user['username'] . '"><span>All snippets</span></a>';
            echo '</div>';
            echo '<div>' . $snippet . '</div>';
            echo '</div>';
        }
    ?>
</div>
