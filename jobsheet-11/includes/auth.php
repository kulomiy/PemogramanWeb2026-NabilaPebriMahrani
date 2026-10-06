<?php
// ====================================================================
// CamRent Studio - Middleware Otentikasi Petugas
// ====================================================================
// Mengecek apakah petugas sudah login dalam session.
// Jika belum login, otomatis redirect ke halaman auth/login.php.
// ====================================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pengecekan data user dalam $_SESSION
if (!isset($_SESSION['user'])) {
    // Deteksi jalur relatif ke auth/login.php berdasarkan kedalaman direktori
    if (file_exists('includes/header.php')) {
        $loginUrl = 'auth/login.php';
    } else {
        $loginUrl = '../auth/login.php';
    }

    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => 'Silakan login terlebih dahulu untuk mengakses halaman ini.'
    ];

    header('Location: ' . $loginUrl);
    exit;
}
