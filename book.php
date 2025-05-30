<?php
require 'includes/auth_check.php';
$pageTitle = "Book Tour";

if (!isset($_GET['package_id'])) {
    header('Location: packages.php');
    exit;
}

$package_id = intval($_GET['package_id']);
require 'includes/db_connect.php';

// Fetch package details
$stmt = $pdo->prepare("SELECT * FROM packages WHERE package_id = ?");
$stmt->execute([$package_id]);
$package = $stmt->fetch();

if (!$package) {
    header('Location: packages.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $travel_date = $_POST['travel_date'];
    $travelers = intval($_POST['travelers']);
    $notes = htmlspecialchars($_POST['notes']);
    
    // Validate travelers count
    if ($travelers < 1 || $travelers > 10) {
        $error = "Number of travelers must be between 1 and 10";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, package_id, travel_date, travelers, notes) 
                                  VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $package_id, $travel_date, $travelers, $notes]);
            
            header('Location: dashboard.php?success=Booking successful!');
            exit;
        } catch (PDOException $e) {
            $error = "Error creating booking: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tour - Serendib Trails</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Book: <?= htmlspecialchars($package['title']) ?></h1>
                <p class="hero-subtitle">Complete your booking details</p>
            </div>
        </div>
    </section>
    
    <section class="dashboard">
        <div class="container">
            <div class="card">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                    <div>
                        <h3>Package Details</h3>
                        <div class="package-details" style="margin-top: 20px;">
                            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                                <img src="<?= htmlspecialchars($package['image_url']) ?>" 
                                     alt="<?= htmlspecialchars($package['title']) ?>" 
                                     style="width: 120px; height: 90px; border-radius: 8px; object-fit: cover;">
                                <div>
                                    <h4><?= htmlspecialchars($package['title']) ?></h4>
                                    <div><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($package['location']) ?></div>
                                </div>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: auto 1fr; gap: 10px; margin-top: 20px;">
                                <div style="color: var(--text-secondary);">Duration:</div>
                                <div><?= $package['duration_days'] ?> days</div>
                                
                                <div style="color: var(--text-secondary);">Price per person:</div>
                                <div>$<?= number_format($package['price'], 2) ?></div>
                                
                                <div style="color: var(--text-secondary);">Total price:</div>
                                <div>
                                    <span id="totalPrice">$<?= number_format($package['price'], 2) ?></span>
                                    <small style="color: var(--text-secondary);">(for 1 traveler)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3>Booking Information</h3>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-error"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" style="margin-top: 20px;">
                            <div class="form-group">
                                <label class="form-label">Travel Date</label>
                                <input type="date" name="travel_date" class="form-input" 
                                       min="<?= date('Y-m-d', strtotime('+3 days')) ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Number of Travelers</label>
                                <input type="number" name="travelers" id="travelers" 
                                       class="form-input" min="1" max="10" value="1" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Special Requests</label>
                                <textarea name="notes" class="form-input" placeholder="Any special requirements..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                                <i class="fas fa-check-circle"></i> Confirm Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        // Calculate total price based on travelers
        const packagePrice = <?= $package['price'] ?>;
        const travelersInput = document.getElementById('travelers');
        const totalPriceElement = document.getElementById('totalPrice');
        
        travelersInput.addEventListener('change', function() {
            const travelers = parseInt(this.value) || 1;
            const total = packagePrice * travelers;
            totalPriceElement.textContent = '$' + total.toFixed(2);
        });
    </script>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>