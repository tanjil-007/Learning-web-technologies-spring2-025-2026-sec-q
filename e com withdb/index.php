<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['role'] === 'admin' ? "dashboard.php" : "shop.php"));
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>ShopEasy</title></head>
<body>
    <h2>ShopEasy</h2>
    <a href="login.php">Customer Login</a> |
    <a href="admin.php">Admin Login</a>
    <br><br>
    Customer: customer1 / pass123<br>
    Admin: admin / admin123
</body>
</html>
