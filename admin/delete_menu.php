<?php
require_once '../includes/functions.php';
require_admin();

if (!isset($_GET['id'], $_GET['csrf']) || !verify_csrf($_GET['csrf'])) {
    die("Invalid request");
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
$stmt->execute([$id]);

header("Location: dashboard.php");
exit;
