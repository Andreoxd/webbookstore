<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../public/index.php">Bookstore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left side -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../public/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/books.php">Books</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        <li><a class="dropdown-item" href="../public/books.php?category=fiction">Fiction</a></li>
                        <li><a class="dropdown-item" href="../public/books.php?category=science">Science</a></li>
                        <li><a class="dropdown-item" href="../public/books.php?category=biography">Biography</a></li>
                        <li><a class="dropdown-item" href="../public/books.php?category=history">History</a></li>
                        <!-- You can dynamically load categories from DB if you want later -->
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../public/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/contact.php">Contact</a>
                </li>
            </ul>

            <!-- Right side -->
            <ul class="navbar-nav">
                <?php if (is_logged_in()): ?>
                    <?php
                        $user = get_current_user_data(); // Make sure you have a function that gets current user info
                        $username = htmlspecialchars($user['username']);
                    ?>
                    <?php if (is_admin()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/dashboard.php">Admin</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <span class="navbar-text text-white mx-2">
                            Welcome, <?= $username ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../auth/logout.php">Logout</a>
                    </li>

                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../auth/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../auth/register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>

<main class="container">
