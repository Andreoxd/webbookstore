<?php
require_once '../../includes/config.php';

if (!is_logged_in() || !is_admin()) {
    redirect('../../auth/login.php');
}

$user_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user || $user['id'] == 0) {
    $_SESSION['error'] = "User not found";
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    
    // Validate inputs
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    // Check if username/email exists for other users
    $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
    $stmt->execute([$username, $email, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        $errors[] = "Username or email already in use by another user";
    }
    
    if (empty($errors)) {
        // Update user
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, is_admin = ? WHERE id = ?");
        $stmt->execute([$username, $email, $is_admin, $user_id]);
        
        // Update password if provided
        if (!empty($_POST['password'])) {
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed_password, $user_id]);
        }
        
        $_SESSION['success'] = "User updated successfully!";
        redirect('index.php');
    }
}

require_once '../../includes/header.php';
?>

<div class="container mt-4">
    <h2>Edit User</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?= $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" 
                   value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" 
                   <?= $user['is_admin'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_admin">Admin User</label>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>