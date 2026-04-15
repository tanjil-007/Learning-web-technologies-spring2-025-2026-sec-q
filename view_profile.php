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
      <fieldset style="width:100%;">
        <legend>PROFILE</legend>
        <div class="profile-box" style="margin-top:8px;">
          <div>
            <table>
              <tr>
                <td>Name</td>
                <td>: <?= htmlspecialchars($user['name']) ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td>: <?= htmlspecialchars($user['email']) ?></td>
              </tr>
              <tr>
                <td>Gender</td>
                <td>: <?= htmlspecialchars($user['gender']) ?></td>
              </tr>
              <tr>
                <td>Date of Birth</td>
                <td>: <?= htmlspecialchars($user['dob']) ?>
                  &nbsp;<a href="change_picture.php" class="link">Change</a>
                </td>
              </tr>
            </table>
            <br>
            <a href="edit_profile.php" class="link">Edit Profile</a>
          </div>
          <div class="profile-pic" style="margin-left:20px;">
            <?php if (!empty($user['picture'])): ?>
              <img src="<?= $user['picture'] ?>" alt="Profile" style="width:80px;height:80px;object-fit:cover;border-radius:50%;">
            <?php else: ?>
              <div style="font-size:60px; color:#555; line-height:1;">&#128100;</div>
            <?php endif; ?>
          </div>
        </div>
      </fieldset>
    </div>
  </div>
<?php footer(); ?>
