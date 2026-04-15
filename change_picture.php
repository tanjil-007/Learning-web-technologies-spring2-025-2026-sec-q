<?php
require 'includes/common.php';
require 'includes/layout.php';
requireLogin();

$uname   = currentUsername();
$user    = currentUser();
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $mime    = mime_content_type($_FILES['picture']['tmp_name']);
        if (!in_array($mime, $allowed)) {
            $error = 'Only JPG, PNG, GIF, or WEBP images are allowed.';
        } elseif ($_FILES['picture']['size'] > 2 * 1024 * 1024) {
            $error = 'Image must be under 2MB.';
        } else {
            $data = file_get_contents($_FILES['picture']['tmp_name']);
            $base64 = 'data:' . $mime . ';base64,' . base64_encode($data);
            $_SESSION['users'][$uname]['picture'] = $base64;
            $user    = currentUser();
            $success = 'Profile picture updated.';
        }
    } else {
        $error = 'Please choose a file to upload.';
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
        <legend>PROFILE PICTURE</legend>
        <div style="margin:10px 0;">
          <?php if (!empty($user['picture'])): ?>
            <img src="<?= $user['picture'] ?>" alt="Profile" style="width:80px;height:80px;object-fit:cover;border-radius:50%;display:block;margin-bottom:8px;">
          <?php else: ?>
            <div style="font-size:70px;color:#555;line-height:1;margin-bottom:8px;">&#128100;</div>
          <?php endif; ?>
        </div>
        <form method="post" action="" enctype="multipart/form-data">
          <div style="margin-bottom:8px;font-size:13px;">
            <input type="file" name="picture" accept="image/*">
          </div>
          <div class="btn-row">
            <input type="submit" value="Submit">
          </div>
        </form>
      </fieldset>
    </div>
  </div>
<?php footer(); ?>
