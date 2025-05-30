<?php
// Redirect to specified URL
function redirect($url) {
    header("Location: $url");
    exit;
}

// Set flash message
function set_flash($message, $type = 'success') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

// Display flash message
function display_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        
        return "<div class='alert alert-{$flash['type']}'>{$flash['message']}</div>";
    }
    return '';
}

// Sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if user is admin
function is_admin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}