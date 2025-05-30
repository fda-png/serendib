<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Ensure user is admin
if ($_SESSION['user_type'] !== 'admin') {
    header('Location: ../dashboard.php');
    exit;
}

// Refresh session data
if (!isset($_SESSION['email'])) {
    require '../includes/db_connect.php';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if ($user) {
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['approved'] = $user['approved'];
        $_SESSION['date_joined'] = $user['date_joined'];
    } else {
        session_destroy();
        header('Location: ../login.php');
        exit;
    }
}
?>