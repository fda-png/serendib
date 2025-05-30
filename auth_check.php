<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Check if user is approved
if ($_SESSION['user_type'] === 'user' && !$_SESSION['approved']) {
    die('Your account is pending admin approval');
}
?>