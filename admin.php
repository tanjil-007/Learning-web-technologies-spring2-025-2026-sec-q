<?php
session_start();
require 'db.php';
$error = "";

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header("Location: dashboard.php"); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("SELECT * FROM users WHERE username=? AND role='admin'");
    $stmt->execute([trim($_POST['username'])]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify(trim($_POST['password']), $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        header("Location: dashboard.php"); exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
    <h2>Admin Login</h2>
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
