<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin.php"); exit;
}

$orders = $db->query("SELECT * FROM orders ORDER BY ordered_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$sales  = $db->query("SELECT product_name, SUM(quantity) AS qty, SUM(total) AS revenue FROM orders GROUP BY product_name ORDER BY revenue DESC")->fetchAll(PDO::FETCH_ASSOC);
$total_revenue = array_sum(array_column($orders, 'total'));
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
    <h2>Admin Dashboard</h2>
    Logged in as: <?= htmlspecialchars($_SESSION['username']) ?> |
    <a href="logout.php">Logout</a>
    <br><br>
    Total Orders: <?= count($orders) ?> | Total Revenue: Tk <?= number_format($total_revenue) ?>

    <h3>Sales Summary</h3>
    <?php if (empty($sales)): ?>
        <p>No sales yet.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr><th>#</th><th>Product</th><th>Qty Sold</th><th>Revenue</th></tr>
            <?php foreach ($sales as $i => $row): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><?= $row['qty'] ?></td>
                <td>Tk <?= number_format($row['revenue']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h3>All Orders</h3>
    <?php if (empty($orders)): ?>
        <p>No orders yet.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr><th>ID</th><th>Customer</th><th>Product</th><th>Qty</th><th>Amount</th><th>Date</th></tr>
            <?php foreach ($orders as $o): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['username']) ?></td>
                <td><?= htmlspecialchars($o['product_name']) ?></td>
                <td><?= $o['quantity'] ?></td>
                <td>Tk <?= number_format($o['total']) ?></td>
                <td><?= $o['ordered_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
