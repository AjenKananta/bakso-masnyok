<?php
// Pastikan session_start() hanya dipanggil sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_secure'   => false, // Set true jika menggunakan HTTPS
        'cookie_httponly' => true,
        'use_strict_mode' => true
    ]);
}

function isLoggedIn() {
    return !empty($_SESSION['user_id']);
}

function isAdmin() {
    // Debugging - tampilkan data session
    error_log("Session data: " . print_r($_SESSION, true));
    
    // Hardcode untuk testing
    if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
        return true;
    }
    
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function redirectIfNotAdmin() {
    if (!isAdmin()) {
        $_SESSION['error'] = "Akses ditolak. Hanya admin yang bisa mengakses.";
        error_log("Access denied for user: " . ($_SESSION['username'] ?? 'Unknown'));
        header('Location: /bakso-mas-nyok2/login.php');
        exit();
    }
}
?>