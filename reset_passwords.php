<?php
require 'includes/db_connect.php';

$users = [
    [
        'email' => 'admin@serendib.lk',
        'password' => 'Admin@123'
    ],
    [
        'email' => 'traveler@example.com',
        'password' => 'Password123'
    ],
    [
        'email' => 'adventure@mail.com',
        'password' => 'Password123'
    ],
    [
        'email' => 'culture@explorer.lk',
        'password' => 'Password123'
    ],
    [
        'email' => 'beach@vacation.com',
        'password' => 'Password123'
    ]
];

try {
    $pdo->beginTransaction();
    
    foreach ($users as $user) {
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $user['email']]);
        echo "Updated password for {$user['email']}<br>";
    }
    
    $pdo->commit();
    echo "All passwords updated successfully!";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}