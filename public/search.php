<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Menu</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php
session_start();
require_once '../config/db.php';
?>

<header>
    <h1>🔍 Search Menu</h1>
</header>

<div class="container">

    <!-- Search Form -->
    <div class="search-box">
        <input type="text" id="search" placeholder="Search by name, cuisine or categories" autocomplete="off">
        <div id="suggestions"></div>
    </div>

    <!-- Search Results -->
    <div id="search-results"></div>

    <!-- CART -->
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

    <p style="margin-top:2rem; text-align:center;">
        <a href="index.php">← Back to Menu</a>
    </p>

</div>

<script>
const searchInput = document.getElementById('search');
const suggestions = document.getElementById('suggestions');
const results = document.getElementById('search-results');

searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim();

    if (query.length < 1) {
        suggestions.innerHTML = '';
        results.innerHTML = '';
        return;
    }

    fetch('ajax_search.php?q=' + encodeURIComponent(query))
        .then(res => res.text())
        .then(data => {
            suggestions.innerHTML = data;
        });
});

function selectSuggestion(text) {
    searchInput.value = text;
    suggestions.innerHTML = '';
    performSearch(text);
}

function performSearch(query) {
    fetch('ajax_search.php?search=' + encodeURIComponent(query))
        .then(res => res.text())
        .then(data => {
            results.innerHTML = data;
        });
}

searchInput.addEventListener('keydown', (e) => {
    if (e.key === "Enter") {
        performSearch(searchInput.value.trim());
        suggestions.innerHTML = '';
    }
});


/*  CART FUNCTIONS       */


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
