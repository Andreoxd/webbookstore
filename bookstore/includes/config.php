<?php
// Start session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400, // 1 day
        'cookie_secure' => isset($_SERVER['HTTPS']), // Only send over HTTPS
        'cookie_httponly' => true, // Prevent JavaScript access
        'cookie_samesite' => 'Strict' // Prevent CSRF
    ]);
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bookstore_db');

// Create connection
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Helper functions
function redirect($url) {
    header("Location: $url");
    exit();
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    if (!is_logged_in()) {
        return false;
    }
    
    // Check if we've already determined admin status in this session
    if (isset($_SESSION['is_admin'])) {
        return $_SESSION['is_admin'];
    }
    
    // If not, check the database
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $_SESSION['is_admin'] = (bool)$user['is_admin'];
            return $_SESSION['is_admin'];
        }
        return false;
    } catch (PDOException $e) {
        // Log error or handle appropriately
        error_log("Admin check failed: " . $e->getMessage());
        return false;
    }
}
function base_url() {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
}

function app_path() {
    $script_path = dirname($_SERVER['SCRIPT_NAME']);
    return rtrim($script_path, '/admin'); // Adjust based on your structure
}

function asset_url($path) {
    return base_url() . app_path() . '/assets/' . ltrim($path, '/');
}

function public_url($path) {
    return base_url() . app_path() . '/public/' . ltrim($path, '/');
}

function admin_url($path) {
    return base_url() . app_path() . '/admin/' . ltrim($path, '/');
}

function auth_url($path) {
    return base_url() . app_path() . '/auth/' . ltrim($path, '/');
}
function get_current_user_data() {
    global $pdo;
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch();
}



?>