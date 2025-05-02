<?php
require_once '../includes/config.php';

// Strict admin check - redirect to login if not admin
if (!is_logged_in() || !is_admin()) {
    redirect('../auth/login.php');
    exit();
}

// Get counts for dashboard
$books_count = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
$users_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .admin-header {
            background: #2c3e50;
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .admin-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logout-btn {
            color: white;
            background: #e74c3c;
            border: none;
            padding: 5px 15px;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .logout-btn:hover {
            background: #c0392b;
            text-decoration: none;
        }
        .stat-card {
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Minimal Admin Header -->
    <header class="admin-header mb-4">
        <div class="container admin-header-content">
            <h1>Admin Panel</h1>
            <a href="../auth/logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <main class="container">
        <h2 class="mb-4">Dashboard Overview</h2>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card stat-card text-white bg-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Books</h5>
                                <h2 class="mb-0"><?= $books_count ?></h2>
                            </div>
                            <a href="books/index.php" class="text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card stat-card text-white bg-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Users</h5>
                                <h2 class="mb-0"><?= $users_count ?></h2>
                            </div>
                            <a href="users/index.php" class="text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>