<?php
require '../includes/auth_check.php';
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit;
}

$pageTitle = "Manage Users";

// Database connection
require '../includes/db_connect.php';

// Fetch users
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Serendib Trails</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-container">
    <?php include '../includes/admin_sidebar.php'; ?>
    
    <main class="admin-content">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>User Management</h1>
            <a href="add_user.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
        
        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['user_id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= $user['user_type'] ?></td>
                        <td>
                            <?php if ($user['approved']): ?>
                                <span style="color: var(--accent-primary);">Approved</span>
                            <?php else: ?>
                                <span style="color: #ff5252;">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="action-btn btn-edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                            <?php if (!$user['approved']): ?>
                                <button class="action-btn btn-approve">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            <?php endif; ?>
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