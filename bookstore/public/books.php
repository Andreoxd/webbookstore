<?php
require_once '../includes/config.php';

// Get all books with search/filter functionality
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY title";
$stmt = $pdo->prepare($query);
$stmt->execute(["%$search%", "%$search%"]);
$books = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Our Book Collection</h2>
        </div>
        <div class="col-md-4">
            <form class="d-flex">
                <input class="form-control me-2" type="search" name="search" placeholder="Search books..." value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
    
    <div class="row">
        <?php foreach ($books as $book): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="../assets/images/books/<?= $book['image'] ?? 'default.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($book['title']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                    <p class="card-text text-muted">by <?= htmlspecialchars($book['author']) ?></p>
                    <p class="card-text"><?= substr(htmlspecialchars($book['description']), 0, 100) ?>...</p>
                    <p class="card-text"><strong>$<?= number_format($book['price'], 2) ?></strong></p>
                </div>
                <div class="card-footer bg-white">
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                    <a href="book.php?id=<?= $book['id'] ?>" class="btn btn-outline-secondary">Details</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>