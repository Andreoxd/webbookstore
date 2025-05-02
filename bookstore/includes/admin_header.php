<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
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
    </style>
</head>
<body>
    <header class="admin-header mb-4">
    <div class="container admin-header-content">
        <h1>Admin Panel</h1>
        <a href="../auth/logout.php" class="logout-btn">Logout</a>
    </div>
</header>


    <main class="container">
