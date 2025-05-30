<?php
require '../includes/auth_check.php';
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit;
}

// Redirect to dashboard
header('Location: dashboard.php');
exit;
?>