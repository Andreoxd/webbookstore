<?php
require_once '../../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../../auth/login.php');
}

// Get all books
$stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
$books = $stmt->fetchAll();

require_once '../../includes/admin_header.php';

?>


<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Books</h2>
        <a href="create.php" class="btn btn-primary">Add New Book</a>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= $book['id'] ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td>$<?= number_format($book['price'], 2) ?></td>
                <td>
                    <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $book['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    

<?php require_once '../../includes/footer.php'; ?>