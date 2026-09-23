<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$id_reg = trim($_POST['id_reg'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$no_ktp = trim($_POST['no_ktp'] ?? '');
$no_wa = trim($_POST['no_wa'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

$errors = [];

if ($id_reg === '') {
    $errors[] = 'ID registrasi wajib diisi.';
}

if ($nama === '') {
    $errors[] = 'Nama lengkap wajib diisi.';
}

if ($no_ktp === '') {
    $errors[] = 'Nomor identitas wajib diisi.';
}

if ($no_wa === '') {
    $errors[] = 'Nomor HP (WhatsApp) wajib diisi.';
}

if ($alamat === '') {
    $errors[] = 'Alamat domisili wajib diisi.';
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => implode(' ', $errors)
    ];

    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

foreach ($_SESSION['anggota'] as $item) {
    if ($item['id_reg'] === $id_reg) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'ID registrasi sudah digunakan.'
        ];

        header('Location: tambah.php');
        exit;
    }
}

$_SESSION['anggota'][] = [
    'id_reg' => $id_reg,
    'nama_lengkap' => $nama,
    'no_ktp' => $no_ktp,
    'no_hp' => $no_wa,
    'alamat' => $alamat,
    'status' => 'Proses Cek'
];

$_SESSION['flash'] = [
    'type' => 'success',
    'message' => 'Data pelanggan berhasil ditambahkan.'
];

header('Location: list.php');
exit;
