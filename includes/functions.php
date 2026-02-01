<?php
// Start session safely 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
require_once __DIR__ . '/../config/db.php';

/* 
   XSS Protection Helper
   */
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

/* 
   Admin Authentication
   */
function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

function require_admin() {
    if (!is_admin_logged_in()) {
        header("Location: /restaurant_system/admin/login.php");
        exit;
    }
}

/* 
   CSRF Protection
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
