<?php 
$pageTitle = "Tour Packages";
include 'includes/header.php'; 

// Database connection
require 'includes/db_connect.php';

// Default sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$order_by = '';

switch ($sort) {
    case 'price_low_high':
        $order_by = 'ORDER BY price ASC';
        break;
    case 'price_high_low':
        $order_by = 'ORDER BY price DESC';
        break;
    case 'duration_short':
        $order_by = 'ORDER BY duration_days ASC';
        break;
    case 'duration_long':
        $order_by = 'ORDER BY duration_days DESC';
        break;
    case 'name_asc':
        $order_by = 'ORDER BY title ASC';
        break;
    case 'name_desc':
        $order_by = 'ORDER BY title DESC';
        break;
    default:
        $order_by = 'ORDER BY package_id DESC';
}

// Fetch packages from database
try {
    $stmt = $pdo->query("SELECT * FROM packages $order_by");
    $packages = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching packages: " . $e->getMessage());
}
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Curated Sri Lanka Experiences</h1>
            <p class="hero-subtitle">Handpicked journeys showcasing the best of our island</p>
        </div>
    </div>
</section>

<section class="dashboard">
    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
                <div class="filter-bar">
                    <button class="filter-btn active">All Tours</button>
                    <button class="filter-btn">Adventure</button>
                    <button class="filter-btn">Cultural</button>
                    <button class="filter-btn">Beach</button>
                    <button class="filter-btn">Wildlife</button>
                </div>
                
                <div>
                    <select id="sortSelect" class="form-input" style="width: auto;">
                        <option value="">Sort By</option>
                        <option value="price_low_high" <?= $sort == 'price_low_high' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_high_low" <?= $sort == 'price_high_low' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="duration_short" <?= $sort == 'duration_short' ? 'selected' : '' ?>>Duration: Short to Long</option>
                        <option value="duration_long" <?= $sort == 'duration_long' ? 'selected' : '' ?>>Duration: Long to Short</option>
                        <option value="name_asc" <?= $sort == 'name_asc' ? 'selected' : '' ?>>Name: A to Z</option>
                        <option value="name_desc" <?= $sort == 'name_desc' ? 'selected' : '' ?>>Name: Z to A</option>
                    </select>
                </div>
            </div>
            
            <div class="packages-grid">
                <?php foreach ($packages as $package): ?>
                <div class="package-card zoom-on-hover">
                    <img src="<?= htmlspecialchars($package['image_url']) ?>" 
                         alt="<?= htmlspecialchars($package['title']) ?>" 
                         class="package-image">
                    <div class="package-overlay">
                        <h4 class="package-title"><?= htmlspecialchars($package['title']) ?></h4>
                        <div class="package-meta">
                            <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($package['location']) ?></span>
                            <span><i class="fas fa-clock"></i> <?= $package['duration_days'] ?> Days</span>
                        </div>
                        <div class="package-price">$<?= number_format($package['price'], 2) ?></div>
                        <a href="contact.php?package_id=<?= $package['package_id'] ?>" class="btn btn-primary" style="margin-top: 15px;">
                            Book Now
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<script>
    // Sorting functionality
    document.getElementById('sortSelect').addEventListener('change', function() {
        if (this.value) {
            window.location.href = `packages.php?sort=${this.value}`;
        }
    });
    
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            // In a real implementation, this would filter packages
        });
    });
</script>

<?php include 'includes/footer.php'; ?>