<?php
require_once '../../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../../auth/login.php');
}

$book_id = $_GET['id'] ?? 0;

// Delete book
$stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
$stmt->execute([$book_id]);

$_SESSION['success'] = "Book deleted successfully!";
redirect('index.php');
?>