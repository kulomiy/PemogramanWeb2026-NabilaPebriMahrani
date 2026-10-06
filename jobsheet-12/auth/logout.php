<?php
// ====================================================================
// CamRent Studio - Proses Logout Petugas
// ====================================================================
// Menghapus seluruh session, mereset cookies session,
// dan memanggil session_destroy() untuk keamanan akun.
// ====================================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Kosongkan semua data dalam array session
$_SESSION = [];

// 2. Hapus session cookie jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 3. Hancurkan session dari server storage
session_destroy();

// 4. Inisialisasi session baru untuk membawa flash message konfirmasi logout
session_start();
$_SESSION['flash'] = [
    'type'    => 'success',
    'message' => 'Anda telah berhasil logout dari sistem rental.'
];

// Redirect ke halaman login petugas
header('Location: login.php');
exit;
