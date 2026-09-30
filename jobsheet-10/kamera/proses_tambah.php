<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

// Validasi metode request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

// Mengambil dan membersihkan input form
$nama_alat = trim($_POST['nama_alat'] ?? '');
$merek     = trim($_POST['merek'] ?? '');
$tahun     = trim($_POST['tahun'] ?? '');
$sn        = trim($_POST['sn'] ?? '');
$stok      = trim($_POST['stok'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');

$errors = [];

// Validasi Form
if ($nama_alat === '') {
    $errors[] = 'Nama alat / lensa wajib diisi.';
}

if ($merek === '') {
    $errors[] = 'Merek wajib diisi.';
}

if ($tahun === '' || !filter_var($tahun, FILTER_VALIDATE_INT) || (int)$tahun < 2010 || (int)$tahun > 2026) {
    $errors[] = 'Tahun pembelian harus antara 2010 sampai 2026.';
}

if ($stok === '' || filter_var($stok, FILTER_VALIDATE_INT) === false || (int)$stok < 0) {
    $errors[] = 'Jumlah stok harus berupa angka 0 atau lebih.';
}

if ($kategori === '') {
    $errors[] = 'Kategori alat wajib dipilih.';
}

// Jika terdapat error validasi input
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => implode(' ', $errors)
    ];

    header('Location: tambah.php');
    exit;
}

// Simpan ke database MySQL menggunakan query INSERT dan lastInsertId()
// serta Prepared Statement (:nama_parameter) untuk keamanan penuh.
try {
    $sql = "INSERT INTO kamera (nama_alat, merek, tahun_beli, sn, stok, kategori) 
            VALUES (:nama_alat, :merek, :tahun_beli, :sn, :stok, :kategori)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama_alat'   => $nama_alat,
        ':merek'       => $merek,
        ':tahun_beli'  => (int)$tahun,
        ':sn'          => $sn !== '' ? $sn : null,
        ':stok'        => (int)$stok,
        ':kategori'    => $kategori
    ]);

    // Mengambil id baru yang dihasilkan MySQL
    $newId = $pdo->lastInsertId();

    $_SESSION['flash'] = [
        'type'    => 'success',
        'message' => 'Data kamera berhasil ditambahkan ke database (ID: ' . $newId . ').'
    ];

    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    // Tangani kemungkinan error database
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => 'Gagal menyimpan data ke database: ' . $e->getMessage()
    ];

    header('Location: tambah.php');
    exit;
}
