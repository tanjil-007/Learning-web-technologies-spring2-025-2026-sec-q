<?php
require 'includes/common.php';

// Remove remember me cookie
if (isset($_COOKIE['rm_user'])) {
    setcookie('rm_user', '', time() - 3600, '/');
}

unset($_SESSION['logged_in']);
header("Location: index.php");
exit();
