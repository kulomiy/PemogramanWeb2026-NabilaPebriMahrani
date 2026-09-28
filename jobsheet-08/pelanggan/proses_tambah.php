<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

// Validasi metode request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

// Mengambil dan membersihkan input form
$id_reg = trim($_POST['id_reg'] ?? '');
$nama   = trim($_POST['nama'] ?? '');
$no_ktp = trim($_POST['no_ktp'] ?? '');
$no_wa  = trim($_POST['no_wa'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

$errors = [];

// Validasi Form
if ($id_reg === '') {
    $errors[] = 'ID registrasi wajib diisi.';
}

if ($nama === '') {
    $errors[] = 'Nama lengkap wajib diisi.';
}

if ($no_ktp === '') {
    $errors[] = 'Nomor identitas (KTP) wajib diisi.';
}

if ($no_wa === '') {
    $errors[] = 'Nomor HP (WhatsApp) wajib diisi.';
}

if ($alamat === '') {
    $errors[] = 'Alamat domisili wajib diisi.';
}

// Jika terdapat error validasi input dasar
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => implode(' ', $errors)
    ];

    header('Location: tambah.php');
    exit;
}

try {
    // PERUBAHAN JOBSHEET 8:
    // Cek apakah id_reg sudah pernah digunakan sebelumnya di database PostgreSQL
    $checkSql = "SELECT COUNT(*) FROM pelanggan WHERE id_reg = :id_reg";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([':id_reg' => $id_reg]);

    if ((int)$checkStmt->fetchColumn() > 0) {
        $_SESSION['flash'] = [
            'type'    => 'error',
            'message' => 'ID registrasi ' . htmlspecialchars($id_reg) . ' sudah digunakan.'
        ];

        header('Location: tambah.php');
        exit;
    }

    // PERUBAHAN JOBSHEET 8:
    // Simpan data ke database menggunakan query INSERT dengan klausa RETURNING id
    // Menggunakan Prepared Statement (:nama_parameter) untuk aspek keamanan (anti-SQL Injection)
    $sql = "INSERT INTO pelanggan (id_reg, nama_lengkap, no_ktp, no_hp, alamat, status) 
            VALUES (:id_reg, :nama_lengkap, :no_ktp, :no_hp, :alamat, :status) 
            RETURNING id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_reg'       => $id_reg,
        ':nama_lengkap' => $nama,
        ':no_ktp'       => $no_ktp,
        ':no_hp'        => $no_wa,
        ':alamat'       => $alamat,
        ':status'       => 'Proses Cek' // Status default pelanggan baru
    ]);

    // Mengambil id auto-increment baru yang digenerate oleh PostgreSQL dari RETURNING id
    $newId = $stmt->fetchColumn();

    $_SESSION['flash'] = [
        'type'    => 'success',
        'message' => 'Data pelanggan berhasil didaftarkan ke database (ID: ' . $newId . ').'
    ];

    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    // Tangani kemungkinan error database
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => 'Gagal menyimpan data pelanggan ke database: ' . $e->getMessage()
    ];

    header('Location: tambah.php');
    exit;
}
