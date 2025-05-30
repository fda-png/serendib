<?php
require '../includes/auth_check.php';
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit;
}

$pageTitle = "Manage Messages";

// Database connection
require '../includes/db_connect.php';

// Fetch messages
$stmt = $pdo->query("SELECT * FROM messages ORDER BY sent_at DESC");
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Management - Serendib Trails</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-container">
    <?php include '../includes/admin_sidebar.php'; ?>
    
    <main class="admin-content">
        <h1>Contact Messages</h1>
        
        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?= date('M d, Y', strtotime($message['sent_at'])) ?></td>
                        <td><?= htmlspecialchars($message['name']) ?></td>
                        <td><?= htmlspecialchars($message['email']) ?></td>
                        <td><?= substr(htmlspecialchars($message['content']), 0, 50) ?>...</td>
                        <td>
                            <button class="action-btn btn-edit" data-id="<?= $message['message_id'] ?>">
                                <i class="fas fa-eye"></i> View
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
    
    <!-- Message Detail Modal -->
    <div class="modal" id="messageModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 2000; align-items: center; justify-content: center;">
        <div class="card" style="width: 90%; max-width: 800px;">
            <h3>Message Details</h3>
            <div id="messageContent" style="margin: 20px 0;">
                <!-- Message content will be loaded here -->
            </div>
            <button class="btn btn-secondary" id="closeModal">
                Close
            </button>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const viewButtons = document.querySelectorAll('.btn-edit');
            const messageModal = document.getElementById('messageModal');
            const messageContent = document.getElementById('messageContent');
            const closeModal = document.getElementById('closeModal');
            
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const messageId = this.getAttribute('data-id');
                    
                    // Fetch message details via AJAX
                    fetch(`get_message.php?id=${messageId}`)
                        .then(response => response.json())
                        .then(data => {
                            messageContent.innerHTML = `
                                <p><strong>Date:</strong> ${data.sent_at}</p>
                                <p><strong>From:</strong> ${data.name} &lt;${data.email}&gt;</p>
                                <div style="margin-top: 20px; background: var(--bg-glass); padding: 15px; border-radius: var(--border-radius);">
                                    ${data.content}
                                </div>
                            `;
                            messageModal.style.display = 'flex';
                        });
                });
            });
            
            closeModal.addEventListener('click', () => {
                messageModal.style.display = 'none';
            });
        });
    </script>
    
    <script src="../js/main.js"></script>
</body>
</html>