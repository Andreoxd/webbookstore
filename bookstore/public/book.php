<?php
require_once '../includes/config.php';

$book_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if (!$book) {
    $_SESSION['error'] = "Book not found";
    redirect('books.php');
}

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <img src="../assets/images/books/<?= $book['image'] ?? 'default.jpg' ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($book['title']) ?>">
        </div>
        <div class="col-md-8">
            <h2><?= htmlspecialchars($book['title']) ?></h2>
            <p class="text-muted">by <?= htmlspecialchars($book['author']) ?></p>
            <h4 class="text-primary">$<?= number_format($book['price'], 2) ?></h4>
            
            <div class="mt-4 mb-4">
                <button class="btn btn-primary btn-lg">Add to Cart</button>
            </div>
            
            <h4>Description</h4>
            <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>