<?php
require_once '../../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../../auth/login.php');
}

// Get book details
$book_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if (!$book) {
    $_SESSION['error'] = "Book not found";
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    
    // Handle file upload if new image provided
    $image = $book['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../assets/images/books/';
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$image);
    }
    
    // Update database
    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, description = ?, price = ?, image = ? WHERE id = ?");
    $stmt->execute([$title, $author, $description, $price, $image, $book_id]);
    
    $_SESSION['success'] = "Book updated successfully!";
    redirect('index.php');
}

require_once '../../includes/header.php';
?>

<div class="container mt-4">
    <h2>Edit Book</h2>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($book['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $book['price'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Current Cover Image</label>
            <?php if ($book['image']): ?>
                <img src="../../assets/images/books/<?= $book['image'] ?>" class="img-thumbnail mb-2" style="max-height: 200px;">
            <?php endif; ?>
            <input type="file" class="form-control" id="image" name="image">
            <small class="text-muted">Leave blank to keep current image</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Book</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>