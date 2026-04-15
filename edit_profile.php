<?php
require 'includes/common.php';
require 'includes/layout.php';
requireLogin();

$user    = currentUser();
$uname   = currentUsername();
$error   = '';
$success = '';

// Pre-fill DOB parts
$dobParts = explode('/', $user['dob']);
$dd   = $dobParts[0] ?? '';
$mm   = $dobParts[1] ?? '';
$yyyy = $dobParts[2] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $dd     = trim($_POST['dd'] ?? '');
    $mm     = trim($_POST['mm'] ?? '');
    $yyyy   = trim($_POST['yyyy'] ?? '');

    if (!$name || !$email || !$gender || !$dd || !$mm || !$yyyy) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {
        $_SESSION['users'][$uname]['name']   = $name;
        $_SESSION['users'][$uname]['email']  = $email;
        $_SESSION['users'][$uname]['gender'] = $gender;
        $_SESSION['users'][$uname]['dob']    = sprintf('%02d/%02d/%04d', $dd, $mm, $yyyy);
        $user    = currentUser();
        $success = 'Profile updated successfully.';
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
        <legend>EDIT PROFILE</legend>
        <form method="post" action="">
          <div class="frow">
            <label>Name</label>
            <span>:</span>&nbsp;
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
          </div>
          <div class="frow">
            <label>Email</label>
            <span>:</span>&nbsp;
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
            <span class="hint">i</span>
          </div>
          <div class="frow">
            <label>Gender</label>
            <span>:</span>&nbsp;
            <label><input type="radio" name="gender" value="Male"
              <?= $user['gender'] === 'Male' ? 'checked' : '' ?>> Male</label>
            <label><input type="radio" name="gender" value="Female"
              <?= $user['gender'] === 'Female' ? 'checked' : '' ?>> Female</label>
            <label><input type="radio" name="gender" value="Other"
              <?= $user['gender'] === 'Other' ? 'checked' : '' ?>> Other</label>
          </div>
          <div class="frow">
            <label>Date of Birth</label>
            <span>:</span>&nbsp;
            <div>
              <div class="dob-wrap">
                <?php
                $dp = explode('/', $user['dob']);
                $d  = $dp[0] ?? '';
                $m2 = $dp[1] ?? '';
                $y  = $dp[2] ?? '';
                ?>
                <input type="text" name="dd" maxlength="2" value="<?= htmlspecialchars($d) ?>">
                /
                <input type="text" name="mm" maxlength="2" value="<?= htmlspecialchars($m2) ?>">
                /
                <input type="text" name="yyyy" maxlength="4" class="yyyy" value="<?= htmlspecialchars($y) ?>">
              </div>
              <small style="font-style:italic;font-size:11px;color:#777;">(dd/mm/yyyy)</small>
            </div>
          </div>
          <div class="btn-row" style="margin-top:10px;">
            <input type="submit" value="Submit">
          </div>
        </form>
      </fieldset>
    </div>
  </div>
<?php footer(); ?>
