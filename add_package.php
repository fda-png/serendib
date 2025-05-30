<?php
require 'auth_check.php';
$pageTitle = "Add New Package";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package - Serendib Trails</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-container">
    <?php include 'admin_sidebar.php'; ?>
    
    <main class="admin-content">
        <h1>Add New Tour Package</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require '../includes/db_connect.php';
            
            $title = htmlspecialchars($_POST['title']);
            $description = htmlspecialchars($_POST['description']);
            $location = htmlspecialchars($_POST['location']);
            $price = floatval($_POST['price']);
            $duration = intval($_POST['duration']);
            $image_url = htmlspecialchars($_POST['image_url']);
            
            try {
                $stmt = $pdo->prepare("INSERT INTO packages (title, description, location, price, duration_days, image_url) 
                                      VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $description, $location, $price, $duration, $image_url]);
                
                header('Location: manage_packages.php?success=Package added successfully');
                exit;
            } catch (PDOException $e) {
                $error = "Error adding package: " . $e->getMessage();
            }
        }
        ?>
        
        <div class="card form-container">
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Package Title</label>
                    <input type="text" name="title" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input" rows="4" required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Price ($)</label>
                        <input type="number" step="0.01" name="price" class="form-input" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Duration (Days)</label>
                        <input type="number" name="duration" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Image URL</label>
                        <input type="text" name="image_url" class="form-input" required>
                    </div>
                </div>
                
                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Package
                    </button>
                    <a href="manage_packages.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
    
    <script src="../js/main.js"></script>
</body>
</html>