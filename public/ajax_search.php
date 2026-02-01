<?php
require_once '../config/db.php';

$q = $_GET['q'] ?? '';
$search = $_GET['search'] ?? '';

if ($q !== '') {
    $stmt = $pdo->prepare("
        SELECT mi.name, c.name AS category_name
        FROM menu_items mi
        LEFT JOIN categories c ON mi.category_id = c.id
        WHERE mi.name LIKE :q 
        OR c.name LIKE :q
        OR mi.price LIKE :q
        LIMIT 5
    ");
    $stmt->execute(['q' => "%$q%"]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($items as $item) {
        echo "<div class='suggestion-item' onclick='selectSuggestion(\"" . addslashes($item['name']) . "\")'>
                " . htmlspecialchars($item['name']) . "
              </div>";
    }
    exit;
}

if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT mi.*, c.name AS category_name
        FROM menu_items mi
        LEFT JOIN categories c ON mi.category_id = c.id
        WHERE mi.name LIKE :s 
        OR c.name LIKE :s
        OR mi.price LIKE :s
        ORDER BY mi.created_at DESC
    ");
    $stmt->execute(['s' => "%$search%"]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($items)) {
        echo "<p style='text-align:center; color:#666; font-style:italic;'>
                No results found for <strong>" . htmlspecialchars($search) . "</strong>.
              </p>";
        exit;
    }

    echo "<div class='menu-grid'>";
    foreach ($items as $item) {
        

        echo "
        <div class='food-card'>
            <h3>" . htmlspecialchars($item['name']) . "</h3>
            
            <div class='food-meta'>
                <span>" . htmlspecialchars($item['category_name'] ?? '—') . "</span>
                <span>Rs." . htmlspecialchars($item['price'] ?? '—') . "</span>
            </div>
            <button class='btn' onclick='addToCart({$item['id']})'>Add to Cart</button>
        </div>";
    }
    echo "</div>";
    exit;
}
