<?php 
$pageTitle = "Contact Us";
include 'includes/header.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // Database connection
    require 'includes/db_connect.php';
    
    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO messages (name, email, content) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);
    
    // Send email (using Mailtrap in development)
    $to = "admin@serendibtrails.lk";
    $subject = "New Contact Form Submission";
    $headers = "From: $email";
    
    // Use mail() function - configure in php.ini for production
    mail($to, $subject, $message, $headers);
    
    echo '<script>showAlert("Your message has been sent successfully!", "success")</script>';
}
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Get in Touch</h1>
            <p class="hero-subtitle">We'd love to help plan your Sri Lankan adventure</p>
        </div>
    </div>
</section>

<section class="dashboard">
    <div class="container">
        <div class="card">
            <div class="dashboard-grid">
                <div class="grid-item half">
                    <h3>Send us a Message</h3>
                    <form id="contactForm" method="POST">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label class="form-label">Your Name</label>
                                <input type="text" name="name" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-input" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-input" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
                
                <div class="grid-item">
                    <div class="card">
                        <h3>Contact Information</h3>
                        <div style="margin-top: 25px;">
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(0,255,157,0.1); display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--accent-primary);">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4>Our Office</h4>
                                    <p>123 Galle Road, Colombo 03, Sri Lanka</p>
                                </div>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(0,255,157,0.1); display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--accent-primary);">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <h4>Phone</h4>
                                    <p>+94 112 345 678</p>
                                </div>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(0,255,157,0.1); display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--accent-primary);">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h4>Email</h4>
                                    <p>info@serendibtrails.lk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>