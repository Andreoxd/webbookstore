<?php
require_once '../includes/config.php';

// Unset all session variables
$_SESSION = [];

// Destroy the session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

session_destroy();

// Redirect to login page with absolute URL
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$login_url = $base_url . dirname(dirname($_SERVER['SCRIPT_NAME'])) . '/auth/login.php';
header("Location: $login_url");
exit();
?>