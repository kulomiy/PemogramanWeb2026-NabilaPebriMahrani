<?php
// ====================================================================
// CamRent Studio - Proses Login Petugas
// ====================================================================
// Memeriksa username dan password menggunakan password_verify(),
// kemudian membuat session user jika autentikasi berhasil.
// ====================================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/csrf.php';

// Validasi metode request hanya POST
csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input form
if ($username === '' || $password === '') {
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => 'Username dan password wajib diisi.'
    ];
    header('Location: login.php');
    exit;
}

try {
    // Ambil data user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifikasi password hash menggunakan password_verify()
    if ($user && password_verify($password, $user['password'])) {
        // Regenerasi session ID untuk keamanan dari session fixation
        session_regenerate_id(true);

        // Simpan data login ke dalam $_SESSION
        $_SESSION['user'] = [
            'id'           => $user['id'],
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap']
        ];

        $_SESSION['flash'] = [
            'type'    => 'success',
            'message' => 'Login berhasil! Selamat datang, ' . $user['nama_lengkap'] . ' 👋'
        ];

        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['flash'] = [
            'type'    => 'error',
            'message' => 'Username atau password yang Anda masukkan salah.'
        ];
        header('Location: login.php');
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => 'Terjadi kesalahan sistem database saat login: ' . $e->getMessage()
    ];
    header('Location: login.php');
    exit;
}
