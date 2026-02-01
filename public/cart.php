<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* CLEAR CART */
if (isset($_POST['clear'])) {
    $_SESSION['cart'] = [];
    echo "Your cart is empty.";
    exit;
}

/* ADD ITEM */
if (!isset($_POST['item_id'])) {
    echo "Invalid request";
    exit;
}

$item_id = (int) $_POST['item_id'];

/* Fetch item safely */
$stmt = $pdo->prepare("SELECT id, name, price FROM menu_items WHERE id = ?");
$stmt->execute([$item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "Item not found";
    exit;
}

/* Add to session cart */
if (isset($_SESSION['cart'][$item_id])) {
    $_SESSION['cart'][$item_id]['qty']++;
} else {
    $_SESSION['cart'][$item_id] = [
        'name' => $item['name'],
        'price' => $item['price'],
        'qty' => 1
    ];
}

/* Display cart */
$total = 0;
$output = '';

foreach ($_SESSION['cart'] as $c) {
    $line = $c['price'] * $c['qty'];
    $total += $line;

    $output .= "<div>
        {$c['name']} × {$c['qty']}
        <span style='float:right;'>RS." . number_format($line, 2) . "</span>
    </div>";
}

$output .= "<hr><strong>Total: Rs." . number_format($total, 2) . "</strong>";

echo $output;
