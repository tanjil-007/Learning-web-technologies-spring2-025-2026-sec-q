<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php"); exit;
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$pid = isset($_POST['pid']) ? (int)$_POST['pid'] : 0;

if (isset($_POST['increase']) && isset($_SESSION['cart'][$pid])) {
    $_SESSION['cart'][$pid]['quantity'] += 1;
}

if (isset($_POST['decrease']) && isset($_SESSION['cart'][$pid])) {
    $_SESSION['cart'][$pid]['quantity'] -= 1;
    if ($_SESSION['cart'][$pid]['quantity'] <= 0) unset($_SESSION['cart'][$pid]);
}

if (isset($_POST['remove'])) {
    unset($_SESSION['cart'][$pid]);
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html>
<head><title>Cart</title></head>
<body>
    <h2>Cart</h2>
    <a href="shop.php">Continue Shopping</a> |
    <a href="logout.php">Logout</a>
    <br><br>
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Cart is empty.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Remove</th></tr>
            <?php foreach ($_SESSION['cart'] as $pid => $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>Tk <?= number_format($item['price']) ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="pid" value="<?= $pid ?>">
                        <input type="submit" name="decrease" value="-">
                        <?= $item['quantity'] ?>
                        <input type="submit" name="increase" value="+">
                    </form>
                </td>
                <td>Tk <?= number_format($item['price'] * $item['quantity']) ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="pid" value="<?= $pid ?>">
                        <input type="submit" name="remove" value="Remove">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><b>Total</b></td>
                <td><b>Tk <?= number_format($total) ?></b></td>
                <td></td>
            </tr>
        </table>
        <br>
        <form method="POST" action="order.php">
            <input type="submit" value="Place Order">
        </form>
    <?php endif; ?>
</body>
</html>
