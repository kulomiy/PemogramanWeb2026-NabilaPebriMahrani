<?php
// ====================================================================
// CamRent Studio - Proses Registrasi Petugas Baru
// ====================================================================
// Melakukan validasi input, pengecekan duplikasi username,
// mengenkripsi password dengan password_hash(), dan menyimpan ke database.
// ====================================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/koneksi.php';

// Validasi metode request hanya POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nama_lengkap       = trim($_POST['nama_lengkap'] ?? '');
$username           = trim($_POST['username'] ?? '');
$password           = $_POST['password'] ?? '';
$konfirmasi_password = $_POST['konfirmasi_password'] ?? '';

$errors = [];

// Validasi Form
if ($nama_lengkap === '') {
    $errors[] = 'Nama lengkap wajib diisi.';
}

if ($username === '') {
    $errors[] = 'Username wajib diisi.';
} elseif (!preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
    $errors[] = 'Username hanya boleh berisi huruf, angka, titik, strip (-), dan underscore (_).';
} elseif (strlen($username) < 3 || strlen($username) > 50) {
    $errors[] = 'Panjang username harus antara 3 sampai 50 karakter.';
}

if ($password === '') {
    $errors[] = 'Password wajib diisi.';
} elseif (strlen($password) < 6) {
    $errors[] = 'Password minimal harus 6 karakter.';
}

if ($password !== $konfirmasi_password) {
    $errors[] = 'Konfirmasi password tidak cocok dengan password.';
}

// Jika terdapat error validasi input dasar
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => implode(' ', $errors)
    ];
    header('Location: register.php');
    exit;
}

try {
    // 1. Cek apakah username sudah ada (cek duplikasi username)
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $checkStmt->execute([':username' => $username]);
    if ((int)$checkStmt->fetchColumn() > 0) {
        $_SESSION['flash'] = [
            'type'    => 'error',
            'message' => 'Username "' . htmlspecialchars($username) . '" sudah digunakan. Silakan gunakan username lain.'
        ];
        header('Location: register.php');
        exit;
    }

    // 2. Hash password menggunakan password_hash() standar keamanan tinggi PHP
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 3. Simpan data user petugas ke database
    $insertStmt = $pdo->prepare("INSERT INTO users (username, password, nama_lengkap) VALUES (:username, :password, :nama_lengkap)");
    $insertStmt->execute([
        ':username'     => $username,
        ':password'     => $hashedPassword,
        ':nama_lengkap' => $nama_lengkap
    ]);

    $_SESSION['flash'] = [
        'type'    => 'success',
        'message' => 'Registrasi petugas berhasil! Silakan login menggunakan akun yang baru dibuat.'
    ];

    header('Location: login.php');
    exit;
} catch (PDOException $e) {
    // Tangani jika terjadi duplicate entry saat concurrent request
    $sqlState = $e->errorInfo[0] ?? $e->getCode();
    $driverCode = $e->errorInfo[1] ?? 0;

    if ($sqlState === '23000' || $sqlState === '23505' || $driverCode === 1062) {
        $_SESSION['flash'] = [
            'type'    => 'error',
            'message' => 'Username "' . htmlspecialchars($username) . '" sudah terdaftar.'
        ];
    } else {
        $_SESSION['flash'] = [
            'type'    => 'error',
            'message' => 'Gagal mendaftarkan akun ke database: ' . $e->getMessage()
        ];
    }

    header('Location: register.php');
    exit;
}
