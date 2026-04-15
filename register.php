<?php
require 'includes/common.php';
require 'includes/layout.php';

if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';
    $gender   = $_POST['gender'] ?? '';
    $dd       = trim($_POST['dd'] ?? '');
    $mm       = trim($_POST['mm'] ?? '');
    $yyyy     = trim($_POST['yyyy'] ?? '');

    if (!$name || !$email || !$username || !$password || !$confirm || !$gender || !$dd || !$mm || !$yyyy) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (isset($_SESSION['users'][$username])) {
        $error = 'Username already exists.';
    } else {
        $dob = sprintf('%02d/%02d/%04d', $dd, $mm, $yyyy);
        if (!isset($_SESSION['users'])) $_SESSION['users'] = [];
        $_SESSION['users'][$username] = [
            'name'     => $name,
            'email'    => $email,
            'username' => $username,
            'password' => $password,
            'gender'   => $gender,
            'dob'      => $dob,
            'picture'  => ''
        ];
        $success = 'Registration successful! <a href="login.php" class="link">Login here</a>.';
    }
}

publicHeader();
?>
  <div class="content">
    <?php if ($error): ?><p class="msg-err"><?= $error ?></p><?php endif; ?>
    <?php if ($success): ?><p class="msg-ok"><?= $success ?></p><?php endif; ?>
    <fieldset style="width:420px;">
      <legend>REGISTRATION</legend>
      <form method="post" action="">
        <div class="frow">
          <label>Name</label>
          <span>:</span>&nbsp;<input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>
        <div class="frow">
          <label>Email</label>
          <span>:</span>&nbsp;<input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          <span class="hint">i</span>
        </div>
        <div class="frow">
          <label>User Name</label>
          <span>:</span>&nbsp;<input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="frow">
          <label>Password</label>
          <span>:</span>&nbsp;<input type="password" name="password">
        </div>
        <div class="frow">
          <label>Confirm Password</label>
          <span>:</span>&nbsp;<input type="password" name="confirm">
        </div>
        <fieldset class="radio-group" style="margin:8px 0;">
          <legend>Gender</legend>
          <label><input type="radio" name="gender" value="Male"
            <?= (($_POST['gender'] ?? '') === 'Male') ? 'checked' : '' ?>> Male</label>
          <label><input type="radio" name="gender" value="Female"
            <?= (($_POST['gender'] ?? '') === 'Female') ? 'checked' : '' ?>> Female</label>
          <label><input type="radio" name="gender" value="Other"
            <?= (($_POST['gender'] ?? '') === 'Other') ? 'checked' : '' ?>> Other</label>
        </fieldset>
        <fieldset class="radio-group" style="margin:8px 0;">
          <legend>Date of Birth</legend>
          <div class="dob-wrap">
            <input type="text" name="dd" placeholder="dd" maxlength="2" value="<?= htmlspecialchars($_POST['dd'] ?? '') ?>">
            /
            <input type="text" name="mm" placeholder="mm" maxlength="2" value="<?= htmlspecialchars($_POST['mm'] ?? '') ?>">
            /
            <input type="text" name="yyyy" placeholder="yyyy" maxlength="4" class="yyyy" value="<?= htmlspecialchars($_POST['yyyy'] ?? '') ?>">
            <span class="hint">(dd/mm/yyyy)</span>
          </div>
        </fieldset>
        <div class="btn-row">
          <input type="submit" value="Submit">
          <input type="reset" value="Reset">
        </div>
      </form>
    </fieldset>
  </div>
<?php footer(); ?>
