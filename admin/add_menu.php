<?php
require_once '../includes/functions.php';
require_admin();

$error = '';

// Fetch categories for creating new item from db
try {
    $categories = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")
                      ->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to load categories");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf']) || !verify_csrf($_POST['csrf'])) {
        die("CSRF validation failed");
    }

    $name        = trim($_POST['name'] ?? '');
    $price       = $_POST['price'] ?? '';
    $category_id = $_POST['category_id'] ?? '';

    if ($name === '' || $price === '' || $category_id === '') {
        $error = "All fields are required";
    } else {
        try {
            $stmt = $pdo->prepare(
                //creating new items
                "INSERT INTO menu_items (name, price, category_id)          
                 VALUES (:name, :price, :category_id)"
            );
        //push newly created data to db:
            $stmt->execute([
                'name'        => $name,
                'price'       => $price,
                'category_id' => $category_id
            ]);

            // $_SESSION['success'] = "Menu item added";
            header("Location: dashboard.php?msg= menu item  added");
            exit;

        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<?php require_once '../includes/header.php'; ?>
<div class="add_container">
<h2>Add Menu Item</h2>

<?php if ($error): ?>
    <div class="error"><?= e($error) ?></div>
<?php endif; ?>

<form class="add-menu" method="POST">

    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

    <label>Food Name</label>
    <input type="text" name="name" required>

    <label>Category</label>
    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>">
                <?= e($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Price</label>
    <input type="number" step="0.01" name="price" required>

    <button class="btn btn-success">Save Item</button>
</form>
</div>

<?php require_once '../includes/footer.php'; ?>
