<?php
// admin/dashboard.php
require 'auth_check.php';
$pageTitle = "Admin Dashboard";

// Database connection
require '../includes/db_connect.php';

// Get stats
$stats = [
    'total_users' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'total_bookings' => $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn(),
    'pending_uploads' => $pdo->query("SELECT COUNT(*) FROM gallery WHERE approved = 0")->fetchColumn(),
    'unread_messages' => $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn(),
    'active_packages' => $pdo->query("SELECT COUNT(*) FROM packages")->fetchColumn(),
    'revenue' => $pdo->query("SELECT SUM(price) FROM bookings JOIN packages ON bookings.package_id = packages.package_id")->fetchColumn()
];

// Get recent bookings
$recentBookings = $pdo->query("SELECT b.*, p.title, u.name 
                              FROM bookings b 
                              JOIN packages p ON b.package_id = p.package_id 
                              JOIN users u ON b.user_id = u.user_id 
                              ORDER BY booking_date DESC LIMIT 5")->fetchAll();

// Get recent messages
$recentMessages = $pdo->query("SELECT * FROM messages ORDER BY sent_at DESC LIMIT 5")->fetchAll();

// Get pending users
$pendingUsers = $pdo->query("SELECT * FROM users WHERE approved = 0 AND user_type = 'user'")->fetchAll();

// Get pending gallery items
$pendingGallery = $pdo->query("SELECT g.*, u.name 
                              FROM gallery g 
                              JOIN users u ON g.user_id = u.user_id 
                              WHERE g.approved = 0 
                              ORDER BY upload_date DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Serendib Trails</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-content {
            padding: 30px;
            background: radial-gradient(circle at top right, #1a1a2e, #121212);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0 40px;
        }
        
        .admin-card {
            background: var(--bg-glass);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            border-color: rgba(0, 255, 157, 0.1);
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            background: linear-gradient(to bottom, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-label {
            color: var(--text-secondary);
            font-size: 14px;
        }
        
        .card {
            background: var(--bg-glass);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .card-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .card-title i {
            font-size: 24px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(0, 255, 157, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-primary);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .data-table th {
            text-align: left;
            padding: 12px 15px;
            background: rgba(0,0,0,0.2);
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 14px;
        }
        
        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            font-size: 14px;
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tr:hover td {
            background: rgba(255,255,255,0.03);
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            transition: var(--transition);
        }
        
        .btn-view {
            background: rgba(0, 150, 255, 0.15);
            color: var(--accent-secondary);
            border: 1px solid rgba(0, 150, 255, 0.2);
        }
        
        .btn-approve {
            background: rgba(0, 200, 83, 0.15);
            color: #00c853;
            border: 1px solid rgba(0, 200, 83, 0.2);
        }
        
        .btn-delete {
            background: rgba(255, 87, 87, 0.15);
            color: #ff5252;
            border: 1px solid rgba(255, 87, 87, 0.2);
        }
        
        .action-btn:hover {
            opacity: 0.8;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }
        
        .badge-confirmed {
            background: rgba(0, 200, 83, 0.15);
            color: #00c853;
        }
        
        .badge-cancelled {
            background: rgba(255, 87, 87, 0.15);
            color: #ff5252;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .action-card {
            background: var(--bg-glass);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            border-color: rgba(0, 255, 157, 0.1);
        }
        
        .action-card i {
            font-size: 32px;
            margin-bottom: 15px;
            color: var(--accent-primary);
        }
        
        .action-card h4 {
            margin-bottom: 10px;
        }
        
        .action-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: rgba(0, 255, 157, 0.1);
            color: var(--accent-primary);
            border-radius: var(--border-radius);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }
        
        .action-card a:hover {
            background: rgba(0, 255, 157, 0.2);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-secondary);
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        @media (max-width: 1024px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="admin-container">
    <?php include 'admin_sidebar.php'; ?>
    
    <main class="admin-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1>Admin Dashboard</h1>
            <div style="color: var(--text-secondary);">Welcome, <?= $_SESSION['name'] ?></div>
        </div>
        
        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="admin-card">
                <div class="stat-value"><?= $stats['total_users'] ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            
            <div class="admin-card">
                <div class="stat-value"><?= $stats['total_bookings'] ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
            
            <div class="admin-card">
                <div class="stat-value"><?= $stats['pending_uploads'] ?></div>
                <div class="stat-label">Pending Uploads</div>
            </div>
            
            <div class="admin-card">
                <div class="stat-value"><?= $stats['unread_messages'] ?></div>
                <div class="stat-label">Unread Messages</div>
            </div>
            
            <div class="admin-card">
                <div class="stat-value"><?= $stats['active_packages'] ?></div>
                <div class="stat-label">Active Packages</div>
            </div>
            
            <div class="admin-card">
                <div class="stat-value">$<?= number_format($stats['revenue'], 2) ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-bolt"></i>
                <h2>Quick Actions</h2>
            </div>
            
            <div class="quick-actions">
                <div class="action-card">
                    <i class="fas fa-plus-circle"></i>
                    <h4>Add Package</h4>
                    <p>Create a new tour package</p>
                    <a href="add_package.php">Add New</a>
                </div>
                
                <div class="action-card">
                    <i class="fas fa-user-check"></i>
                    <h4>Approve Users</h4>
                    <p>Review pending accounts</p>
                    <a href="manage_users.php">View Users</a>
                </div>
                
                <div class="action-card">
                    <i class="fas fa-images"></i>
                    <h4>Gallery Moderation</h4>
                    <p>Approve user uploads</p>
                    <a href="manage_gallery.php">Review Images</a>
                </div>
                
                <div class="action-card">
                    <i class="fas fa-chart-line"></i>
                    <h4>View Reports</h4>
                    <p>Analyze booking data</p>
                    <a href="reports.php">Generate Reports</a>
                </div>
            </div>
        </div>
        
        <div class="grid-2">
            <!-- Recent Bookings -->
            <div class="card">
                <div class="card-title">
                    <i class="fas fa-calendar-check"></i>
                    <div>
                        <h2>Recent Bookings</h2>
                        <p style="color: var(--text-secondary); font-size: 14px;">Latest tour bookings</p>
                    </div>
                </div>
                
                <?php if (count($recentBookings) > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tour</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentBookings as $booking): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['title']) ?></td>
                                <td><?= htmlspecialchars($booking['name']) ?></td>
                                <td><?= date('M d, Y', strtotime($booking['travel_date'])) ?></td>
                                <td>
                                    <span class="badge badge-<?= $booking['status'] ?>">
                                        <?= ucfirst($booking['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="booking_details.php?id=<?= $booking['booking_id'] ?>" class="action-btn btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div style="text-align: right; margin-top: 15px;">
                        <a href="manage_bookings.php" class="btn btn-secondary">View All Bookings</a>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-suitcase"></i>
                        <h4>No Recent Bookings</h4>
                        <p>There are no recent bookings to display</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Pending Actions -->
            <div class="card">
                <div class="card-title">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h2>Pending Actions</h2>
                        <p style="color: var(--text-secondary); font-size: 14px;">Require your attention</p>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <!-- Pending Users -->
                    <div>
                        <h3 style="margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-users"></i> Users
                            <span style="margin-left: auto; background: rgba(255, 193, 7, 0.2); color: #ffc107; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                <?= count($pendingUsers) ?>
                            </span>
                        </h3>
                        
                        <?php if (count($pendingUsers) > 0): ?>
                            <div style="background: var(--bg-glass); border-radius: var(--border-radius); padding: 15px;">
                                <?php foreach ($pendingUsers as $user): ?>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <div>
                                        <div><?= htmlspecialchars($user['name']) ?></div>
                                        <div style="font-size: 12px; color: var(--text-secondary);"><?= htmlspecialchars($user['email']) ?></div>
                                    </div>
                                    <a href="approve_user.php?id=<?= $user['user_id'] ?>" class="action-btn btn-approve">
                                        Approve
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                <i class="fas fa-check-circle"></i> No pending users
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Pending Gallery -->
                    <div>
                        <h3 style="margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-images"></i> Gallery
                            <span style="margin-left: auto; background: rgba(255, 193, 7, 0.2); color: #ffc107; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                <?= count($pendingGallery) ?>
                            </span>
                        </h3>
                        
                        <?php if (count($pendingGallery) > 0): ?>
                            <div style="background: var(--bg-glass); border-radius: var(--border-radius); padding: 15px;">
                                <?php foreach ($pendingGallery as $image): ?>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 40px; height: 40px; border-radius: 6px; overflow: hidden;">
                                            <img src="../gallery/uploads/<?= htmlspecialchars($image['image_url']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div style="font-size: 13px;"><?= htmlspecialchars($image['caption']) ?></div>
                                    </div>
                                    <a href="approve_image.php?id=<?= $image['image_id'] ?>" class="action-btn btn-approve">
                                        Approve
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                <i class="fas fa-check-circle"></i> No pending images
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Recent Messages -->
            <div class="card">
                <div class="card-title">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h2>Recent Messages</h2>
                        <p style="color: var(--text-secondary); font-size: 14px;">Latest inquiries from users</p>
                    </div>
                </div>
                
                <?php if (count($recentMessages) > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentMessages as $message): ?>
                            <tr>
                                <td><?= htmlspecialchars($message['name']) ?></td>
                                <td><?= htmlspecialchars($message['email']) ?></td>
                                <td><?= date('M d', strtotime($message['sent_at'])) ?></td>
                                <td>
                                    <a href="message_details.php?id=<?= $message['message_id'] ?>" class="action-btn btn-view">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div style="text-align: right; margin-top: 15px;">
                        <a href="manage_messages.php" class="btn btn-secondary">View All Messages</a>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-envelope-open"></i>
                        <h4>No Recent Messages</h4>
                        <p>There are no new messages to display</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <script src="../js/main.js"></script>
    <script>
        // Update dashboard every 60 seconds
        setInterval(() => {
            window.location.reload();
        }, 60000);
    </script>
</body>
</html>