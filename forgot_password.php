<?php
require 'includes/common.php';
require 'includes/layout.php';

$msg = '';
$found = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!$email) {
        $msg = '<span class="msg-err">Please enter your email.</span>';
    } else {
        $found_user = null;
        if (!empty($_SESSION['users'])) {
            foreach ($_SESSION['users'] as $uname => $u) {
                if (strtolower($u['email']) === strtolower($email)) {
                    $found_user = $u;
                    break;
                }
            }
        }
        if ($found_user) {
            $msg = '<span class="msg-ok">Your password is: <strong>' . htmlspecialchars($found_user['password']) . '</strong></span>';
        } else {
            $msg = '<span class="msg-err">No account found with that email.</span>';
        }
    }
}

publicHeader();
?>
  <div class="content">
    <?php if ($msg): ?><p style="margin-bottom:8px;"><?= $msg ?></p><?php endif; ?>
    <fieldset style="width:320px;">
      <legend>FORGOT PASSWORD</legend>
      <form method="post" action="">
        <div class="frow">
          <label>Enter Email:</label>
          <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="btn-row" style="margin-top:10px;">
          <input type="submit" value="Submit">
        </div>
      </form>
    </fieldset>
  </div>
<?php footer(); ?>
