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
            echo '<span class="user-label">'; ?>

            <script type="text/javascript">
              var user = "<?php echo $colouredUser; ?>";
              document.write(DOMPurify.sanitize(user));
            </script>

            <?php
            echo '</span>' . '<a href="/src/view/snippets.php?userId=' . $user['id'] .
            "&userName=" . $user['username'] . '"><span>All snippets</span></a>';

            if (SessionManager::isLoggedIn()) {
              echo '&nbsp;<a href="' . $user['homepage'] .  '">Homepage</a>';
            }
            ?>

            </div>

            <div>
              <div>
                <script type="text/javascript">
                  var snip = "<?php echo $snippet; ?>";
                  document.write(DOMPurify.sanitize(snip));
                </script>
              </div>
            </div>
          </div>
          <?php
        }
    ?>
</div>
