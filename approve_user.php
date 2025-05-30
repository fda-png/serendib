<?php
require 'auth_check.php';

if (!isset($_GET['id'])) {
    header('Location: manage_users.php');
    exit;
}

$user_id = intval($_GET['id']);
require '../includes/db_connect.php';

try {
    $stmt = $pdo->prepare("UPDATE users SET approved = 1 WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    header('Location: manage_users.php?success=User approved successfully');
    exit;
} catch (PDOException $e) {
    header('Location: manage_users.php?error=Error approving user');
    exit;
}
?>