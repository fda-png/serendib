<footer style="background: var(--bg-secondary); padding: 60px 0 30px; margin-top: 60px;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px;">
            <div>
                <div class="logo" style="font-size: 28px; margin-bottom: 20px;">Serendib Trails</div>
                <p style="color: var(--text-secondary); line-height: 1.7;">
                    Discover the hidden gems of Sri Lanka with our expertly crafted tours and travel experiences.
                </p>
                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <a href="#" style="color: var(--text-secondary); font-size: 20px;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: var(--text-secondary); font-size: 20px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: var(--text-secondary); font-size: 20px;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: var(--text-secondary); font-size: 20px;"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div>
                <h3 style="margin-bottom: 20px; color: var(--text-primary);">Quick Links</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 12px;"><a href="index.php" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);"><i class="fas fa-chevron-right" style="margin-right: 8px;"></i> Home</a></li>
                    <li style="margin-bottom: 12px;"><a href="about.php" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);"><i class="fas fa-chevron-right" style="margin-right: 8px;"></i> About Us</a></li>
                    <li style="margin-bottom: 12px;"><a href="packages.php" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);"><i class="fas fa-chevron-right" style="margin-right: 8px;"></i> Tour Packages</a></li>
                    <li style="margin-bottom: 12px;"><a href="gallery.php" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);"><i class="fas fa-chevron-right" style="margin-right: 8px;"></i> Gallery</a></li>
                    <li style="margin-bottom: 12px;"><a href="contact.php" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);"><i class="fas fa-chevron-right" style="margin-right: 8px;"></i> Contact Us</a></li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'admin'): ?>
                    <li style="margin-bottom: 12px;"><a href="admin/dashboard.php" style="color: var(--text-secondary); text-decoration: none; transition: var(--transition);"><i class="fas fa-chevron-right" style="margin-right: 8px;"></i> Admin Dashboard</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div>
                <h3 style="margin-bottom: 20px; color: var(--text-primary);">Contact Info</h3>
                <ul style="list-style: none; padding: 0; color: var(--text-secondary);">
                    <li style="margin-bottom: 15px; display: flex; align-items: flex-start;">
                        <i class="fas fa-map-marker-alt" style="margin-right: 10px; margin-top: 5px;"></i>
                        <span>123 Galle Road, Colombo 03, Sri Lanka</span>
                    </li>
                    <li style="margin-bottom: 15px; display: flex; align-items: center;">
                        <i class="fas fa-phone" style="margin-right: 10px;"></i>
                        <span>+94 112 345 678</span>
                    </li>
                    <li style="margin-bottom: 15px; display: flex; align-items: center;">
                        <i class="fas fa-envelope" style="margin-right: 10px;"></i>
                        <span>info@serendibtrails.lk</span>
                    </li>
                </ul>
            </div>
            
            <div>
                <h3 style="margin-bottom: 20px; color: var(--text-primary);">Newsletter</h3>
                <p style="color: var(--text-secondary); margin-bottom: 20px;">
                    Subscribe to receive travel inspiration, exclusive offers, and updates.
                </p>
                <form style="display: flex; gap: 10px;">
                    <input type="email" placeholder="Your email" class="form-input" style="flex: 1;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 50px; padding-top: 30px; text-align: center; color: var(--text-secondary);">
            &copy; <?= date('Y') ?> Serendib Trails. All Rights Reserved.
        </div>
    </div>
</footer>

<div class="alert-container" id="alertContainer"></div>
<script src="js/main.js"></script>
</body>
</html>