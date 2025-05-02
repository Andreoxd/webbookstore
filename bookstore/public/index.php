<?php
require_once '../includes/config.php';

// Get featured books
$stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC LIMIT 4");
$featured_books = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<!-- Hero Section -->
<div class="bg-dark text-white text-center py-5 mb-5" style="background: url('../assets/images/hero-bookstore.jpg') center/cover no-repeat;">
    <div class="container">
        <h1 class="display-4 fw-bold">Discover Your Next Favorite Book</h1>
        <p class="lead">Thousands of titles across every genre, waiting for you.</p>
        <a href="books.php" class="btn btn-primary btn-lg mt-3">Browse Books</a>
    </div>
</div>

<!-- Featured Books Section -->
<div class="container">
    <h2 class="mb-4">Featured Books</h2>
    
    <div class="row">
        <?php foreach ($featured_books as $book): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="../assets/images/books/<?= $book['image'] ?? 'default.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($book['title']) ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                    <p class="card-text">by <?= htmlspecialchars($book['author']) ?></p>
                    <p class="card-text fw-bold">$<?= number_format($book['price'], 2) ?></p>
                    <a href="#" class="btn btn-outline-primary mt-auto">Add to Cart</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Categories Section -->
<div class="container my-5">
    <h2 class="mb-4 text-center">Browse by Category</h2>
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="p-4 bg-light rounded shadow-sm">
                <h4>Fiction</h4>
                <p>Adventure, Mystery, Romance and more.</p>
                <a href="books.php?category=fiction" class="btn btn-sm btn-primary">Explore</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="p-4 bg-light rounded shadow-sm">
                <h4>Science</h4>
                <p>Explore the world of science and discovery.</p>
                <a href="books.php?category=science" class="btn btn-sm btn-primary">Explore</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="p-4 bg-light rounded shadow-sm">
                <h4>Biographies</h4>
                <p>Inspiring life stories of great individuals.</p>
                <a href="books.php?category=biography" class="btn btn-sm btn-primary">Explore</a>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="bg-light py-5">
    <div class="container">
        <h2 class="mb-5 text-center">What Our Readers Say</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <blockquote class="blockquote">
                    <p>"Amazing selection and super fast delivery!"</p>
                    <footer class="blockquote-footer">Emily R.</footer>
                </blockquote>
            </div>
            <div class="col-md-4 mb-4">
                <blockquote class="blockquote">
                    <p>"I found rare books that I couldn't find anywhere else."</p>
                    <footer class="blockquote-footer">Michael T.</footer>
                </blockquote>
            </div>
            <div class="col-md-4 mb-4">
                <blockquote class="blockquote">
                    <p>"Highly recommend this bookstore to all book lovers."</p>
                    <footer class="blockquote-footer">Sofia K.</footer>
                </blockquote>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Signup -->
<div class="bg-primary text-white py-5">
    <div class="container text-center">
        <h2>Stay Updated!</h2>
        <p>Subscribe to our newsletter for the latest arrivals and deals.</p>
        <form class="d-flex justify-content-center mt-3">
            <input type="email" class="form-control w-50 me-2" placeholder="Enter your email">
            <button type="submit" class="btn btn-light">Subscribe</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
