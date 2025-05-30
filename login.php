<?php
session_start();
$pageTitle = "Login";
include 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'includes/db_connect.php';
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['approved'] = $user['approved'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['date_joined'] = $user['date_joined'];
            
            // Redirect based on user type
            if ($user['user_type'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: dashboard.php');
            }
            exit;
        } else {
            $error = "Invalid email or password";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

?>

<section class="hero">
    <div class="container">
        <div class="card" style="max-width: 500px; margin: 100px auto;">
            <h2 class="hero-title" style="text-align: center;">Login to Your Account</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error" style="background: rgba(255, 87, 87, 0.15); border: 1px solid rgba(255, 87, 87, 0.3); border-radius: var(--border-radius); padding: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-circle" style="color: #ff5252;"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                
                <div style="text-align: right; margin-bottom: 20px;">
                    <a href="#" style="color: var(--accent-primary); text-decoration: none;">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                
                <div style="text-align: center; margin-top: 20px;">
                    <a href="register.php">Don't have an account? Register</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>