<?php
require 'auth_check.php';

if (!isset($_GET['id'])) {
    header('Location: manage_packages.php');
    exit;
}

$package_id = intval($_GET['id']);
require '../includes/db_connect.php';

try {
    $stmt = $pdo->prepare("DELETE FROM packages WHERE package_id = ?");
    $stmt->execute([$package_id]);
    
    header('Location: manage_packages.php?success=Package deleted successfully');
    exit;
} catch (PDOException $e) {
    header('Location: manage_packages.php?error=Error deleting package');
    exit;
}
?>