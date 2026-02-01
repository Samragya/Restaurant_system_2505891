<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu & Ordering</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php
session_start();


if (!empty($_SESSION['success'])) {
    echo "<div class='success'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}

if (!empty($_SESSION['error'])) {
    echo "<div class='error'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}

/* Load helpers */
if (file_exists('../includes/functions.php')) {
    require_once '../includes/functions.php';
}

/* Load DB */
require_once '../config/db.php';
?>

<header>
    <h1 class="page-title">♨️ Cafe by Sams 🍔</h1>
</header>

<div class="container">

    <h2 class="menu">Our Menu</h2>

    <?php
    try {
        /*  JOIN categories to get category name */
        $stmt = $pdo->query("
            SELECT 
                menu_items.id,
                menu_items.name,
                menu_items.description,
                menu_items.price,
                categories.name AS category_name
            FROM menu_items
            JOIN categories ON menu_items.category_id = categories.id
            ORDER BY menu_items.created_at DESC
        ");

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$items) {
            echo "<p style='text-align:center; color:#666;'>No menu items available.</p>";
        } else {
            echo "<div class='menu-grid'>";

            foreach ($items as $item) {
                echo "
                <div class='food-card'>
                    <h3>" . e($item['name']) . "</h3>
                    <p>" . e($item['description']) . "</p>

                    <div class='food-meta'>
                        <span class='price'>Rs." . number_format($item['price'], 2) . "</span>
                        <span class='category'>" . e($item['category_name']) . "</span>
                    </div>

                    <button class='btn' onclick='addToCart({$item["id"]})'>
                        Add to Cart
                    </button>
                </div>
                ";
            }

            echo "</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='error'>Database Error: " . e($e->getMessage()) . "</div>";
    }
    ?>

    <div id="cart">
        <h3>🛒 Your Cart</h3>
        <div id="cart-items">Your cart is empty.</div>
        <p>Total: <strong>Rs.<span id="cart-total">0.00</span></strong></p>

        <form id="order-form" method="POST" action="place_order.php" style="display:none; margin-top:20px;">
            <label>Full Name</label>
            <input type="text" name="customer_name" required>
            <label>Table Number (1-8)</label>
            <input type="number" name="table_number" min="1" max="8" required>

            <button type="submit" class="btn btn-success">Place Order</button>
            <button type="button" onclick="clearCart()">Clear Cart</button>
        </form>
    </div>

    <div class="nav-container">
        <a href="search.php" class="nav-link">🔍 Explore Foods</a>
        <a href="../admin/login.php" class="nav-link">Admin Area</a>
    </div>

</div>

<footer class="footer">
    Ordering<br>
    © <?= date('Y') ?> Restaurant System • Kathmandu
</footer>

<script>
function addToCart(id) {
    fetch('cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'item_id=' + id
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('cart-items').innerHTML = html;
        document.getElementById('order-form').style.display = 'block';
    });
}

function clearCart() {
    fetch('cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'clear=1'
    }).then(() => {
        document.getElementById('cart-items').innerHTML = 'Your cart is empty.';
        document.getElementById('order-form').style.display = 'none';
    });
}
</script>

</body>
</html>
