<?php
session_start();
require 'db.php';
$error = "";

if (isset($_SESSION['user_id'])) { header("Location: shop.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("SELECT * FROM users WHERE username=? AND role='customer'");
    $stmt->execute([trim($_POST['username'])]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify(trim($_POST['password']), $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        header("Location: shop.php"); exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Customer Login</title></head>
<body>
    <h2>Customer Login</h2>
    <a href="index.php">Home</a>
    <br><br>
    <?php if ($error) echo "<p>$error</p>"; ?>
    <form method="POST">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
