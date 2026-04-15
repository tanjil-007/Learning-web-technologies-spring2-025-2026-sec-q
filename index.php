<?php
require 'includes/common.php';
require 'includes/layout.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

publicHeader();
?>
  <div class="content">
    <p><strong>Welcome to xCompany</strong></p>
  </div>
<?php footer(); ?>
