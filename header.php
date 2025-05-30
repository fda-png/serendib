<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serendib Trails - <?= $pageTitle ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="fade-in">
        <div class="container nav-container">
            <div class="logo">Serendib Trails</div>
            <nav class="nav-links">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
                <a href="packages.php"><i class="fas fa-suitcase"></i> Packages</a>
                <a href="gallery.php"><i class="fas fa-images"></i> Gallery</a>
                <a href="contact.php"><i class="fas fa-phone"></i> Contact</a>
            </nav>
            <div class="nav-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-user"></i> Dashboard</a>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-secondary"><i class="fas fa-user"></i> Login</a>
                    <a href="register.php" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
            <button class="mobile-menu-btn" id="menuToggle"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <div class="mobile-menu-overlay" id="mobileOverlay"></div>
    
    <div class="mobile-menu" id="mobileMenu">
        <div class="logo">Serendib Trails</div>
        <nav class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
            <a href="packages.php"><i class="fas fa-suitcase"></i> Packages</a>
            <a href="gallery.php"><i class="fas fa-images"></i> Gallery</a>
            <a href="contact.php"><i class="fas fa-phone"></i> Contact</a>
            <div class="nav-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-user"></i> Dashboard</a>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-secondary"><i class="fas fa-user"></i> Login</a>
                    <a href="register.php" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>