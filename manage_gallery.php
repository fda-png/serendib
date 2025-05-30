<?php
require '../includes/auth_check.php';
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit;
}

$pageTitle = "Manage Gallery";

// Database connection
require '../includes/db_connect.php';

// Fetch gallery images
$stmt = $pdo->query("SELECT g.*, u.name AS user_name 
                     FROM gallery g 
                     JOIN users u ON g.user_id = u.user_id");
$gallery = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management - Serendib Trails</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-container">
    <?php include '../includes/admin_sidebar.php'; ?>
    
    <main class="admin-content">
        <h1>Gallery Moderation</h1>
        
        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Caption</th>
                        <th>Uploaded By</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gallery as $image): ?>
                    <tr>
                        <td>
                            <img src="../gallery/uploads/<?= htmlspecialchars($image['image_url']) ?>" 
                                 style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px;">
                        </td>
                        <td><?= htmlspecialchars($image['caption']) ?></td>
                        <td><?= htmlspecialchars($image['user_name']) ?></td>
                        <td><?= date('M d, Y', strtotime($image['upload_date'])) ?></td>
                        <td>
                            <?php if ($image['approved']): ?>
                                <span style="color: var(--accent-primary);">Approved</span>
                            <?php else: ?>
                                <span style="color: #ff5252;">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$image['approved']): ?>
                                <button class="action-btn btn-approve">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            <?php endif; ?>
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