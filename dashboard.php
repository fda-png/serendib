<?php
require 'includes/auth_check.php';
$pageTitle = "User Dashboard";
include 'includes/header.php';

require 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT b.*, p.title, p.location, p.image_url 
                      FROM bookings b 
                      JOIN packages p ON b.package_id = p.package_id 
                      WHERE b.user_id = ?
                      ORDER BY b.booking_date DESC");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();

$is_approved = $_SESSION['approved'];
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
            <p class="hero-subtitle">Manage your bookings and travel plans</p>
        </div>
    </div>
</section>

<section class="dashboard">
    <div class="container">
        <?php if (!$is_approved): ?>
            <div class="card" style="background: rgba(255, 193, 7, 0.15); border-left: 4px solid #ffc107; margin-bottom: 30px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-info-circle" style="font-size: 24px; color: #ffc107;"></i>
                    <div>
                        <h3>Account Pending Approval</h3>
                        <p>Your account is awaiting admin approval. You'll be able to make bookings once approved.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="dashboard-grid">
            <!-- Bookings Section -->
            <div class="grid-item half">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>Your Bookings</h3>
                    </div>
                    
                    <?php if (count($bookings) > 0): ?>
                        <div style="margin-top: 20px;">
                            <?php foreach ($bookings as $booking): ?>
                            <div class="booking-item" style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <div style="display: flex; gap: 20px; align-items: center;">
                                    <img src="<?= htmlspecialchars($booking['image_url']) ?>" 
                                         alt="<?= htmlspecialchars($booking['title']) ?>" 
                                         style="width: 100px; height: 70px; border-radius: 8px; object-fit: cover;">
                                    <div style="flex: 1;">
                                        <h4><?= htmlspecialchars($booking['title']) ?></h4>
                                        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px;">
                                            <div>
                                                <small>Location</small>
                                                <div><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($booking['location']) ?></div>
                                            </div>
                                            <div>
                                                <small>Travel Date</small>
                                                <div><i class="fas fa-calendar-day"></i> <?= date('M d, Y', strtotime($booking['travel_date'])) ?></div>
                                            </div>
                                            <div>
                                                <small>Status</small>
                                                <div style="color: <?= 
                                                    $booking['status'] === 'confirmed' ? 'var(--accent-primary)' : 
                                                    ($booking['status'] === 'pending' ? '#ffc107' : '#ff5252') 
                                                ?>;">
                                                    <?= ucfirst($booking['status']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-secondary">Details</button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px 20px;">
                            <i class="fas fa-suitcase" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 20px;"></i>
                            <h4>No Bookings Yet</h4>
                            <p>You haven't booked any tours yet. Browse our packages to start your adventure!</p>
                            <a href="packages.php" class="btn btn-primary" style="margin-top: 20px;">
                                <i class="fas fa-compass"></i> Explore Tours
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Account Information -->
            <div class="grid-item">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h3>Account Information</h3>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--bg-glass); display: flex; align-items: center; justify-content: center; font-size: 32px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h4><?= htmlspecialchars($_SESSION['name']) ?></h4>
                                <div style="color: var(--text-secondary);">Member since <?= date('M Y', strtotime($_SESSION['date_joined'])) ?></div>
                            </div>
                        </div>
                        
                        <div style="background: var(--bg-glass); border-radius: var(--border-radius); padding: 20px;">
                            <div style="display: grid; grid-template-columns: auto 1fr; gap: 15px; align-items: center;">
                                <div style="color: var(--text-secondary);">Email:</div>
                                <div><?= htmlspecialchars($_SESSION['email']) ?></div>
                                
                                <div style="color: var(--text-secondary);">Account Status:</div>
                                <div>
                                    <?php if ($is_approved): ?>
                                        <span style="color: var(--accent-primary);"><i class="fas fa-check-circle"></i> Approved</span>
                                    <?php else: ?>
                                        <span style="color: #ffc107;"><i class="fas fa-clock"></i> Pending Approval</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div style="color: var(--text-secondary);">Member Type:</div>
                                <div><?= ucfirst($_SESSION['user_type']) ?></div>
                            </div>
                        </div>
                        
                        <div style="margin-top: 30px; display: grid; gap: 15px;">
                            <a href="edit_profile.php" class="btn btn-secondary">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </a>
                            <a href="change_password.php" class="btn btn-secondary">
                                <i class="fas fa-lock"></i> Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gallery Uploads -->
            <div class="grid-item">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <h3>Your Gallery Uploads</h3>
                    </div>
                    
                    <div style="text-align: center; padding: 30px 20px;">
                        <i class="fas fa-camera" style="font-size: 48px; color: var(--text-secondary); margin-bottom: 20px;"></i>
                        <h4>Share Your Memories</h4>
                        <p>Upload photos from your travels to share with the community</p>
                        <a href="upload.php" class="btn btn-primary" style="margin-top: 20px;">
                            <i class="fas fa-cloud-upload-alt"></i> Upload Photos
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="grid-item full">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3>Recent Activity</h3>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(0,255,157,0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-suitcase" style="color: var(--accent-primary);"></i>
                                </div>
                                <div>
                                    <div>Booked "Ella Mountain Adventure"</div>
                                    <small style="color: var(--text-secondary);">2 days ago</small>
                                </div>
                            </div>
                            <div style="color: var(--accent-primary);">$249.00</div>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(0,150,255,0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="color: var(--accent-secondary);"></i>
                                </div>
                                <div>
                                    <div>Uploaded photo to gallery</div>
                                    <small style="color: var(--text-secondary);">5 days ago</small>
                                </div>
                            </div>
                            <div style="color: var(--accent-secondary);">Pending</div>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,193,7,0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-check" style="color: #ffc107;"></i>
                                </div>
                                <div>
                                    <div>Account created</div>
                                    <small style="color: var(--text-secondary);">2 weeks ago</small>
                                </div>
                            </div>
                            <div style="color: #ffc107;">Completed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>