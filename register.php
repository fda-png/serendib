<?php 
session_start();
$pageTitle = "Create Account";
include 'includes/header.php'; 

// Initialize variables
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'includes/db_connect.php';
    
    $name = htmlspecialchars($_POST['name']);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long";
    } else {
        try {
            // Check if email exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $error = "Email already registered";
            } else {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hashedPassword]);
                
                // Get new user ID
                $user_id = $pdo->lastInsertId();
                
                // Set session
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_type'] = 'user';
                $_SESSION['approved'] = 0; // Needs admin approval
                $_SESSION['name'] = $name;
                
                $success = "Account created successfully! You can now access your dashboard.";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<section class="hero">
    <div class="container">
        <div class="card" style="max-width: 500px; margin: 100px auto;">
            <h2 class="hero-title" style="text-align: center;">Create Your Account</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error" style="background: rgba(255, 87, 87, 0.15); border: 1px solid rgba(255, 87, 87, 0.3); border-radius: var(--border-radius); padding: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-circle" style="color: #ff5252;"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success" style="background: rgba(0, 200, 83, 0.15); border: 1px solid rgba(0, 200, 83, 0.3); border-radius: var(--border-radius); padding: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle" style="color: #00c853;"></i>
                    <span><?= $success ?></span>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password (min 8 characters)</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-input" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
                
                <div style="text-align: center; margin-top: 20px;">
                    <a href="login.php">Already have an account? Login</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>