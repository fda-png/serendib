<?php
$pageTitle = "Discover Sri Lanka";
include 'includes/header.php';
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Discover the Hidden Gems of Sri Lanka</h1>
            <p class="hero-subtitle">Experience the perfect blend of ancient culture, breathtaking landscapes, and unforgettable adventures with our curated travel experiences.</p>
            <a href="packages.php" class="btn btn-primary pulse"><i class="fas fa-compass"></i> Explore Tours</a>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-value">12k+</div>
                    <div class="stat-label">Happy Travelers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">78%</div>
                    <div class="stat-label">Repeat Customers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">200+</div>
                    <div class="stat-label">Tour Packages</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dashboard">
    <div class="container">
        <div class="dashboard-grid">
            <!-- Popular Destinations -->
            <div class="grid-item half">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h3>Popular Destinations</h3>
                    </div>
                    <div class="packages-grid">
                        <div class="package-card zoom-on-hover">
                            <img src="images/sl8.jpg" alt="Sigiriya" class="package-image">
                            <div class="package-overlay">
                                <h4 class="package-title">Sigiriya Rock Fortress</h4>
                                <div class="package-meta">
                                    <span><i class="fas fa-clock"></i> 2 Days</span>
                                    <span><i class="fas fa-users"></i> Group Tour</span>
                                </div>
                                <div class="package-price">$189</div>
                            </div>
                        </div>
                        
                        <div class="package-card zoom-on-hover">
                            <img src="images/sl4.jpg" alt="Ella" class="package-image">
                            <div class="package-overlay">
                                <h4 class="package-title">Ella Mountain Adventure</h4>
                                <div class="package-meta">
                                    <span><i class="fas fa-clock"></i> 3 Days</span>
                                    <span><i class="fas fa-users"></i> Small Group</span>
                                </div>
                                <div class="package-price">$249</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Stats -->
            <div class="grid-item">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Traveler Insights</h3>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">0.8%</div>
                        <div class="stat-label">Customer Churn Rate</div>
                    </div>
                    <div class="progress-bar" style="margin-top: 20px;">
                        <div style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                            <div style="width: 20%; height: 100%; background: var(--accent-primary); border-radius: 4px;"></div>
                        </div>
                    </div>
                    <div style="margin-top: 30px;">
                        <div class="form-group">
                            <button class="btn btn-primary" style="width: 100%;">
                                <i class="fas fa-download"></i> Download Full Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="grid-item full">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Contact Us</h3>
                    </div>
                    <form id="contactForm" action="contact.php" method="POST">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label class="form-label">Your Name</label>
                                <input type="text" name="name" class="form-input" placeholder="John Smith" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-input" placeholder="hello@example.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-input" placeholder="Tour Inquiry">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-input" placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Travel Stats -->
            <div class="grid-item">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                        <h3>Travel Stats</h3>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">-10%</div>
                        <div class="stat-label">Bounce Rate</div>
                    </div>
                    <div class="stat-item" style="margin-top: 25px;">
                        <div class="stat-value">-20%</div>
                        <div class="stat-label">Page Exit Rate</div>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Tours -->
            <div class="grid-item">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3>Upcoming Tours</h3>
                    </div>
                    <div class="tour-item" style="padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <div style="display: flex; justify-content: space-between;">
                            <div>Galle Fort Walk</div>
                            <div style="color: var(--accent-primary);">May 28</div>
                        </div>
                        <div style="color: var(--text-secondary); font-size: 14px; margin-top: 5px;">
                            <i class="fas fa-users"></i> 12 spots left
                        </div>
                    </div>
                    <div class="tour-item" style="padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <div style="display: flex; justify-content: space-between;">
                            <div>Kandy Cultural Tour</div>
                            <div style="color: var(--accent-primary);">Jun 02</div>
                        </div>
                        <div style="color: var(--text-secondary); font-size: 14px; margin-top: 5px;">
                            <i class="fas fa-users"></i> 8 spots left
                        </div>
                    </div>
                    <div class="tour-item" style="padding: 12px 0;">
                        <div style="display: flex; justify-content: space-between;">
                            <div>Yala Safari Adventure</div>
                            <div style="color: var(--accent-primary);">Jun 10</div>
                        </div>
                        <div style="color: var(--text-secondary); font-size: 14px; margin-top: 5px;">
                            <i class="fas fa-users"></i> 5 spots left
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ROI Card -->
            <div class="grid-item">
                <div class="card">
                    <div class="card-title">
                        <div class="card-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h3>Return On Investment</h3>
                    </div>
                    <div class="stat-value" style="font-size: 32px; margin-top: 10px;">24.5%</div>
                    <div style="margin-top: 20px; display: flex; gap: 15px;">
                        <div style="flex: 1; text-align: center;">
                            <div style="font-size: 18px; font-weight: 600;">Top 1</div>
                            <div style="color: var(--text-secondary); font-size: 14px;">Regional Rank</div>
                        </div>
                        <div style="flex: 1; text-align: center;">
                            <div style="font-size: 18px; font-weight: 600;">98%</div>
                            <div style="color: var(--text-secondary); font-size: 14px;">Satisfaction</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>