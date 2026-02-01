<?php
session_start();
require_once '../config/db.php';

/* MARK AS SERVED */
if (isset($_POST['serve_order'])) {
    $order_id = (int)$_POST['order_id'];
    $stmt = $pdo->prepare("UPDATE orders SET status = 'served' WHERE id = ?");
    $stmt->execute([$order_id]);
}

/* FETCH ORDERS */
$stmt = $pdo->query("
    SELECT o.*, oi.item_name, oi.qty, oi.price
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    ORDER BY o.created_at DESC
");

$orders = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $orders[$row['id']]['order'] = [
        'customer_name' => $row['customer_name'],
        'table_number' => $row['table_number'],
        'total' => $row['total'],
        'created_at' => $row['created_at'],
        'status' => $row['status']
    ];
    $orders[$row['id']]['items'][] = [
        'name' => $row['item_name'],
        'qty' => $row['qty'],
        'price' => $row['price']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>
    <h1>📋 Orders</h1>
</header>

<div class="container">

    <?php foreach ($orders as $order_id => $data): ?>
        <div class="order-card">
            <h3>Order #<?= $order_id ?></h3>
            <p><strong>Customer:</strong> <?= htmlspecialchars($data['order']['customer_name']) ?></p>
            <p><strong>Table:</strong> <?= htmlspecialchars($data['order']['table_number']) ?></p>
            <p><strong>Total:</strong> Rs.<?= number_format($data['order']['total'], 2) ?></p>
            <p><strong>Time:</strong> <?= $data['order']['created_at'] ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($data['order']['status']) ?></p>

            <ul>
                <?php foreach ($data['items'] as $item): ?>
                    <li>
                        <?= htmlspecialchars($item['name']) ?> x<?= $item['qty'] ?> —
                        Rs.<?= number_format($item['price'], 2) ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- MARK AS SERVED BUTTON -->
            <?php if ($data['order']['status'] === 'pending'): ?>
                <form method="POST" style="margin-top:10px;">
                    <input type="hidden" name="order_id" value="<?= $order_id ?>">
                    <button type="submit" name="serve_order" class="btn btn-success">
                        Mark as Served
                    </button>
                </form>
            <?php else: ?>
                <span class="served-label">Served ✔️</span>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>
<a href="dashboard.php">BACK TO DASHBOARD</a>

</body>
</html>
