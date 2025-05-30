<?php
require '../includes/auth_check.php';
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit;
}

$pageTitle = "Manage Packages";

// Database connection
require '../includes/db_connect.php';

// Fetch packages
$stmt = $pdo->query("SELECT * FROM packages");
$packages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages - Serendib Trails</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-container">
    <?php include '../includes/admin_sidebar.php'; ?>
    
    <main class="admin-content">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Tour Package Management</h1>
            <a href="add_package.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Package
            </a>
        </div>
        
        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Package</th>
                        <th>Location</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($packages as $package): ?>
                    <tr>
                        <td><?= $package['package_id'] ?></td>
                        <td><?= htmlspecialchars($package['title']) ?></td>
                        <td><?= htmlspecialchars($package['location']) ?></td>
                        <td><?= $package['duration_days'] ?> days</td>
                        <td>$<?= number_format($package['price'], 2) ?></td>
                        <td>
                            <button class="action-btn btn-edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    
    <script src="../js/main.js"></script>
</body>
</html>