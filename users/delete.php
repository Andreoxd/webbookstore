<?php
require_once '../../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../../auth/login.php');
}

$user_id = $_GET['id'] ?? 0;

// Prevent deleting static admin or current user
if ($user_id == 0 || $user_id == $_SESSION['user_id']) {
    $_SESSION['error'] = "You cannot delete this user";
    redirect('index.php');
}

// Delete user
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

$_SESSION['success'] = "User deleted successfully!";
redirect('index.php');
?>