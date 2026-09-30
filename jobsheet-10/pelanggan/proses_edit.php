<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: list.php'); exit; }

$id      = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
$id_reg  = trim($_POST['id_reg'] ?? '');
$nama    = trim($_POST['nama'] ?? '');
$no_ktp  = trim($_POST['no_ktp'] ?? '');
$no_wa   = trim($_POST['no_wa'] ?? '');
$alamat  = trim($_POST['alamat'] ?? '');
$status  = trim($_POST['status'] ?? '');
$errors = [];

if (!$id) $errors[] = 'ID pelanggan tidak valid.';
if ($id_reg === '') $errors[] = 'ID registrasi wajib diisi.';
if ($nama === '') $errors[] = 'Nama lengkap wajib diisi.';
if ($no_ktp === '') $errors[] = 'Nomor identitas wajib diisi.';
if ($no_wa === '') $errors[] = 'Nomor HP wajib diisi.';
if ($alamat === '') $errors[] = 'Alamat domisili wajib diisi.';
if (!in_array($status, ['Proses Cek','Terverifikasi'], true)) $errors[] = 'Status pelanggan tidak valid.';

if ($errors) {
    $_SESSION['flash'] = ['type'=>'error','message'=>implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode((string)$id)); exit;
}

try {
    $check = $pdo->prepare('SELECT id FROM pelanggan WHERE id_reg = :id_reg AND id <> :id');
    $check->execute([':id_reg'=>$id_reg, ':id'=>$id]);
    if ($check->fetchColumn()) {
        $_SESSION['flash'] = ['type'=>'error','message'=>'No. Pelanggan ' . $id_reg . ' sudah dipakai, gunakan nomor lain.'];
        header('Location: edit.php?id=' . urlencode((string)$id)); exit;
    }

    $sql = 'UPDATE pelanggan
            SET id_reg=:id_reg, nama_lengkap=:nama_lengkap, no_ktp=:no_ktp,
                no_hp=:no_hp, alamat=:alamat, status=:status
            WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_reg'=>$id_reg,
        ':nama_lengkap'=>$nama,
        ':no_ktp'=>$no_ktp,
        ':no_hp'=>$no_wa,
        ':alamat'=>$alamat,
        ':status'=>$status,
        ':id'=>$id
    ]);

    $_SESSION['flash'] = ['type'=>'success','message'=>'Data pelanggan berhasil diperbarui.'];
    header('Location: list.php'); exit;
} catch (PDOException $e) {
    $sqlState = $e->errorInfo[0] ?? $e->getCode();
    $driverCode = $e->errorInfo[1] ?? 0;
    $_SESSION['flash'] = ($sqlState === '23000' || $sqlState === '23505' || $driverCode === 1062)
        ? ['type'=>'error','message'=>'No. Pelanggan ' . $id_reg . ' sudah dipakai, gunakan nomor lain.']
        : ['type'=>'error','message'=>'Data pelanggan gagal diperbarui.'];
    header('Location: edit.php?id=' . urlencode((string)$id)); exit;
}
