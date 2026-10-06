<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/csrf.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id        = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
$nama_alat = trim($_POST['nama_alat'] ?? '');
$merek     = trim($_POST['merek'] ?? '');
$tahun     = trim($_POST['tahun'] ?? '');
$sn        = trim($_POST['sn'] ?? '');
$stok      = trim($_POST['stok'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');
$errors = [];

if (!$id) $errors[] = 'ID kamera tidak valid.';
if ($nama_alat === '') $errors[] = 'Nama alat / lensa wajib diisi.';
if ($merek === '') $errors[] = 'Merek wajib diisi.';
if ($tahun === '' || filter_var($tahun, FILTER_VALIDATE_INT) === false || (int)$tahun < 2010 || (int)$tahun > 2026) {
    $errors[] = 'Tahun pembelian harus antara 2010 sampai 2026.';
}
if ($stok === '' || filter_var($stok, FILTER_VALIDATE_INT) === false || (int)$stok < 0) {
    $errors[] = 'Jumlah stok harus berupa angka 0 atau lebih.';
}
if ($kategori === '') $errors[] = 'Kategori alat wajib dipilih.';

if ($errors) {
    $_SESSION['flash'] = ['type'=>'error', 'message'=>implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode((string)$id));
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id FROM kamera WHERE id = :id');
    $stmt->execute([':id'=>$id]);
    if (!$stmt->fetchColumn()) {
        $_SESSION['flash'] = ['type'=>'error', 'message'=>'Data kamera tidak ditemukan.'];
        header('Location: list.php');
        exit;
    }

    $sql = 'UPDATE kamera
            SET nama_alat = :nama_alat, merek = :merek, tahun_beli = :tahun_beli,
                sn = :sn, stok = :stok, kategori = :kategori
            WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama_alat'=>$nama_alat,
        ':merek'=>$merek,
        ':tahun_beli'=>(int)$tahun,
        ':sn'=>$sn !== '' ? $sn : null,
        ':stok'=>(int)$stok,
        ':kategori'=>$kategori,
        ':id'=>$id
    ]);

    $_SESSION['flash'] = ['type'=>'success', 'message'=>'Data kamera berhasil diperbarui.'];
    header('Location: list.php');
    exit;
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type'=>'error', 'message'=>'Data kamera gagal diperbarui.'];
    header('Location: edit.php?id=' . urlencode((string)$id));
    exit;
}
