<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$nama_alat = trim($_POST['nama_alat'] ?? '');
$merek = trim($_POST['merek'] ?? '');
$tahun = trim($_POST['tahun'] ?? '');
$sn = trim($_POST['sn'] ?? '');
$stok = trim($_POST['stok'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');

$errors = [];

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

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => implode(' ', $errors)
    ];

    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['kamera'])) {
    $_SESSION['kamera'] = [];
}

$_SESSION['kamera'][] = [
    'nama_alat' => $nama_alat,
    'merek' => $merek,
    'tahun_beli' => (int)$tahun,
    'stok' => (int)$stok,
    'sn' => $sn,
    'kategori' => $kategori
];

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data kamera berhasil ditambahkan.'
];

header('Location: list.php');
exit;
