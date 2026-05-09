<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php"); exit;
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $pid = (int)$_POST['pid'];
    $stmt = $db->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$pid]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$pid] = ['name' => $product['name'], 'price' => $product['price'], 'quantity' => 1];
        }
        $message = $product['name'] . " added to cart.";
    }
}

$products   = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
$cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
?>
<!DOCTYPE html>
<html>
<head><title>Shop</title></head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
    <a href="cart.php">Cart (<?= $cart_count ?>)</a> |
    <a href="logout.php">Logout</a>
    <br><br>
    <?php if ($message) echo "<p>$message</p>"; ?>
    <table border="1" cellpadding="8">
        <tr><th>Product</th><th>Price</th><th>Action</th></tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td>Tk <?= number_format($p['price']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="pid" value="<?= $p['id'] ?>">
                    <input type="submit" name="add" value="Add to Cart">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
