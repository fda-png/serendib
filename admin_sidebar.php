<aside class="admin-sidebar">
    <div class="logo" style="margin-bottom: 30px; font-size: 24px;">Admin Panel</div>
    
    <nav class="admin-nav">
        <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="manage_users.php" class="<?= basename($_SERVER['PHP_SELF']) === 'manage_users.php' ? 'active' : '' ?>">
            <i class="fas fa-users"></i> Manage Users
        </a>
        <a href="manage_packages.php" class="<?= basename($_SERVER['PHP_SELF']) === 'manage_packages.php' ? 'active' : '' ?>">
            <i class="fas fa-suitcase"></i> Manage Packages
        </a>
        <a href="manage_gallery.php" class="<?= basename($_SERVER['PHP_SELF']) === 'manage_gallery.php' ? 'active' : '' ?>">
            <i class="fas fa-images"></i> Gallery Moderation
        </a>
        <a href="manage_messages.php" class="<?= basename($_SERVER['PHP_SELF']) === 'manage_messages.php' ? 'active' : '' ?>">
            <i class="fas fa-envelope"></i> Contact Messages
        </a>
        <a href="../logout.php" style="margin-top: 30px; color: #ff5252;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>