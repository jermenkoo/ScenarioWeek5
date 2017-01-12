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

            if ($user['homepage'] && isset($_COOKIE['user']) && validCredentials($_COOKIE['user'], $_COOKIE['pw'])) {
              echo '&nbsp;<a href="' . $user['homepage'] .  '">Homepage</a>';
            }
            ?>

            </div>

            <div>
              <div class="snip-text">
                <script type="text/javascript">
                  var snip = "<?php echo $snippet; ?>";
                  var user = "<?php echo $colouredUser; ?>";
                  document.write(DOMPurify.sanitize(snip));
                  document.querySelector('.user-label').innerHTML = DOMPurify.sanitize(user);
                </script>
              </div>
            </div>
          </div>
          <?php
        }
    ?>
</div>
