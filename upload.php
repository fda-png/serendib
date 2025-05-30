<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: gallery.php');
    exit;
}

require 'includes/auth_check.php';
require 'includes/db_connect.php';

$caption = htmlspecialchars($_POST['caption']);
$user_id = $_SESSION['user_id'];

// File upload handling
$target_dir = "gallery/uploads/";
$uploadOk = 1;

// Check if image file is an actual image
if (!isset($_FILES["image"]) || $_FILES["image"]["size"] == 0) {
    header('Location: gallery.php?error=' . urlencode('No file selected'));
    exit;
}

$check = getimagesize($_FILES["image"]["tmp_name"]);
if ($check === false) {
    header('Location: gallery.php?error=' . urlencode('File is not an image'));
    exit;
}

// Check file size (max 5MB)
if ($_FILES["image"]["size"] > 5000000) {
    header('Location: gallery.php?error=' . urlencode('File is too large (max 5MB)'));
    exit;
}

// Allow certain file formats
$imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
$allowed_formats = ["jpg", "jpeg", "png", "gif"];
if (!in_array($imageFileType, $allowed_formats)) {
    header('Location: gallery.php?error=' . urlencode('Only JPG, JPEG, PNG & GIF files are allowed'));
    exit;
}

// Generate unique filename
$new_filename = uniqid() . '.' . $imageFileType;
$target_path = $target_dir . $new_filename;

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
    try {
        $stmt = $pdo->prepare("INSERT INTO gallery (user_id, image_url, caption) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $new_filename, $caption]);
        
        header('Location: gallery.php?success=' . urlencode('Image uploaded successfully! It will appear after admin approval.'));
        exit;
    } catch (PDOException $e) {
        // Delete the uploaded file if DB insert fails
        if (file_exists($target_path)) {
            unlink($target_path);
        }
        header('Location: gallery.php?error=' . urlencode('Database error: ' . $e->getMessage()));
        exit;
    }
} else {
    header('Location: gallery.php?error=' . urlencode('Error uploading file'));
    exit;
}
?>