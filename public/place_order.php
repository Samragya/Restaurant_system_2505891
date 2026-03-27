<?php
session_start();
require_once '../config/db.php';

if (empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Cart is empty";
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customer_name = trim($_POST['customer_name']);
    $table_number = (int)$_POST['table_number'];

    // Validation
    if ($customer_name === '' || $table_number < 1 || $table_number > 8) {
        $_SESSION['error'] = "Invalid customer name or table number";
        header("Location: index.php");
        exit;
    }

    // Calculate total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }

    // Insert into orders with status = pending
    $status = 'pending';
    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, table_number, total, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$customer_name, $table_number, $total, $status]);

    $order_id = $pdo->lastInsertId(); //retrieve last order id

    // Insert order items
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, item_id, item_name, price, qty, line_total) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($_SESSION['cart'] as $item_id => $item) {
        $line_total = $item['price'] * $item['qty'];
        $stmt->execute([$order_id, $item_id, $item['name'], $item['price'], $item['qty'], $line_total]);
    }

    // Clear cart
    $_SESSION['cart'] = [];

    // Use session message (secure)
    $_SESSION['success'] = "Order placed successfully";
    header("Location: index.php");
    exit;
}
?>
