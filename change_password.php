<?php
require 'includes/common.php';
require 'includes/layout.php';
requireLogin();

$uname   = currentUsername();
$user    = currentUser();
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current'] ?? '';
    $new     = $_POST['new_pass'] ?? '';
    $retype  = $_POST['retype'] ?? '';

    if (!$current || !$new || !$retype) {
        $error = 'All fields are required.';
    } elseif ($user['password'] !== $current) {
        $error = 'Current password is incorrect.';
    } elseif ($new !== $retype) {
        $error = 'New passwords do not match.';
    } elseif (strlen($new) < 4) {
        $error = 'Password must be at least 4 characters.';
    } else {
        $_SESSION['users'][$uname]['password'] = $new;
        $success = 'Password changed successfully.';
    }
}

userHeader();
?>
  <div class="layout">
    <?php sidebar(); ?>
    <div class="main">
      <?php if ($error): ?><p class="msg-err"><?= $error ?></p><?php endif; ?>
      <?php if ($success): ?><p class="msg-ok"><?= $success ?></p><?php endif; ?>
      <fieldset style="width:100%;">
        <legend>CHANGE PASSWORD</legend>
        <form method="post" action="">
          <div class="frow">
            <label>Current Password</label>
            <span>:</span>&nbsp;
            <input type="password" name="current">
          </div>
          <div class="frow" style="color:green;">
            <label>New Password</label>
            <span>:</span>&nbsp;
            <input type="password" name="new_pass">
          </div>
          <div class="frow" style="color:red;">
            <label>Retype New Password :</label>
            <input type="password" name="retype">
          </div>
          <div class="btn-row" style="margin-top:10px;">
            <input type="submit" value="Submit">
          </div>
        </form>
      </fieldset>
    </div>
  </div>
<?php footer(); ?>
