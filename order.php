<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php"); exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php"); exit;
}

$stmt = $db->prepare("INSERT INTO orders (user_id,username,product_name,quantity,total) VALUES (?,?,?,?,?)");
foreach ($_SESSION['cart'] as $item) {
    $stmt->execute([$_SESSION['user_id'], $_SESSION['username'], $item['name'], $item['quantity'], $item['price'] * $item['quantity']]);
}

$items = $_SESSION['cart'];
$total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items));
$_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html>
<head><title>Order Placed</title></head>
<body>
    <h2>Order Placed!</h2>
    <p>Thank you, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
    <table border="1" cellpadding="8">
        <tr><th>Product</th><th>Qty</th><th>Subtotal</th></tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>Tk <?= number_format($item['price'] * $item['quantity']) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2"><b>Total</b></td>
            <td><b>Tk <?= number_format($total) ?></b></td>
        </tr>
    </table>
    <br>
    <a href="shop.php">Continue Shopping</a>
</body>
</html>
