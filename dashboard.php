<?php
require 'includes/common.php';
require 'includes/layout.php';
requireLogin();

$user = currentUser();
userHeader();
?>
  <div class="layout">
    <?php sidebar(); ?>
    <div class="main">
      <p><strong>Welcome <?= htmlspecialchars($user['name']) ?></strong></p>
    </div>
  </div>
<?php footer(); ?>
