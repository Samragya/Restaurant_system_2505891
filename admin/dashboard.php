<?php
require_once '../includes/functions.php';
require_admin();

/*
 Fetch menu items with category name
*/
$sql = "
    SELECT 
        m.id,
        m.name,
        m.price,
        c.name AS category
    FROM menu_items m
    JOIN categories c ON m.category_id = c.id
    ORDER BY m.created_at DESC
";

$items = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once '../includes/header.php'; ?>

<div class="admin-container">

<h1 class="page-title">Admin Dashboard</h1>

<a href="add_menu.php" class="btn-add">➕ Add Menu Item</a>



<table class="cart-table">
    <tr>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Action</th>
    </tr>

    <?php if (empty($items)): ?>
        <tr>
            <td colspan="4" style="text-align:center; color:#777;">
                No menu items found.
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?= e($item['name']) ?></td>
            <td><?= e($item['category']) ?></td>
            <td>Rs.<?= number_format($item['price'], 2) ?></td>
            <td>
                <a class="btn danger"
                   href="delete_menu.php?id=<?= $item['id'] ?>&csrf=<?= csrf_token() ?>"
                   onclick="return confirm('Delete this item?')">
                   Delete
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<div class="admin-nav"> 
        <a href="view_order.php">View Orders</a>
        
        <a href="logout.php" class="alogout">Logout</a>
</div>
</div>




