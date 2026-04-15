<?php
require 'includes/common.php';
require 'includes/layout.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (!$username || !$password) {
        $error = 'Please enter username and password.';
    } elseif (!isset($_SESSION['users'][$username])) {
        $error = 'Username not found.';
    } elseif ($_SESSION['users'][$username]['password'] !== $password) {
        $error = 'Incorrect password.';
    } else {
        $_SESSION['logged_in'] = $username;
        if ($remember) {
            setcookie('rm_user', $username, time() + (30 * 24 * 3600), '/');
        }
        header("Location: dashboard.php");
        exit();
    }
}

publicHeader();
?>
  <div class="content">
    <?php if ($error): ?><p class="msg-err"><?= $error ?></p><?php endif; ?>
    <fieldset style="width:340px;">
      <legend>LOGIN</legend>
      <form method="post" action="">
        <div class="frow">
          <label>User Name :</label>
          <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="frow">
          <label>Password &nbsp;:</label>
          <input type="password" name="password">
        </div>
        <div style="margin:8px 0; font-size:13px;">
          <label><input type="checkbox" name="remember"> Remember Me</label>
        </div>
        <div class="btn-row">
          <input type="submit" value="Submit">
          <a href="forgot_password.php" class="forgot-link">Forgot Password?</a>
        </div>
      </form>
    </fieldset>
  </div>
<?php footer(); ?>
