<?php 
$pageTitle = "Travel Gallery";
include 'includes/header.php'; 

// Database connection
require 'includes/db_connect.php';

// Fetch approved gallery images
try {
    $stmt = $pdo->query("SELECT * FROM gallery WHERE approved = 1");
    $gallery = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching gallery: " . $e->getMessage());
}

// Handle upload success/error messages
$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Traveler Moments</h1>
            <p class="hero-subtitle">Discover Sri Lanka through the lens of our community</p>
        </div>
    </div>
</section>

<section class="dashboard">
    <div class="container">
        <div class="card">
            <?php if ($success): ?>
                <div class="alert alert-success" style="margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error" style="margin-bottom: 20px;">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <div class="gallery-grid">
                <?php foreach ($gallery as $image): ?>
                <div class="gallery-item">
                    <img src="gallery/uploads/<?= htmlspecialchars($image['image_url']) ?>" 
                         alt="<?= htmlspecialchars($image['caption']) ?>">
                    <div class="gallery-overlay">
                        <p><?= htmlspecialchars($image['caption']) ?></p>
                        <div class="reaction-bar">
                            <button class="reaction-btn">
                                <i class="fas fa-heart"></i> 42
                            </button>
                            <button class="reaction-btn">
                                <i class="fas fa-comment"></i> 8
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (isset($_SESSION['user_id'])): ?>
            <div style="margin-top: 40px; text-align: center;">
                <button class="btn btn-primary" id="uploadTrigger">
                    <i class="fas fa-cloud-upload-alt"></i> Share Your Photos
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Upload Modal -->
<div class="modal" id="uploadModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 2000; align-items: center; justify-content: center;">
    <div class="card" style="width: 90%; max-width: 600px;">
        <h3>Upload Travel Photo</h3>
        <form id="galleryForm" action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Photo Caption</label>
                <input type="text" name="caption" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Select Image</label>
                <input type="file" name="image" id="imageUpload" accept="image/*" required>
                <img id="imagePreview" class="image-preview">
            </div>
            
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload
                </button>
                <button type="button" class="btn btn-secondary" id="cancelUpload">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Gallery upload functionality
    document.addEventListener('DOMContentLoaded', () => {
        const uploadTrigger = document.getElementById('uploadTrigger');
        const uploadModal = document.getElementById('uploadModal');
        const cancelUpload = document.getElementById('cancelUpload');
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('imagePreview');
        
        if (uploadTrigger) {
            uploadTrigger.addEventListener('click', () => {
                uploadModal.style.display = 'flex';
            });
        }
        
        if (cancelUpload) {
            cancelUpload.addEventListener('click', () => {
                uploadModal.style.display = 'none';
            });
        }
        
        if (imageUpload) {
            imageUpload.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>

<?php include 'includes/footer.php'; ?>