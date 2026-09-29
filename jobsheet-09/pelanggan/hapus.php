<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php'); exit;
}

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['flash'] = ['type'=>'error','message'=>'ID pelanggan tidak valid.'];
    header('Location: list.php'); exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM pelanggan WHERE id = :id');
    $stmt->execute([':id'=>$id]);
    $_SESSION['flash'] = $stmt->rowCount() > 0
        ? ['type'=>'success','message'=>'Data pelanggan berhasil dihapus.']
        : ['type'=>'error','message'=>'Data pelanggan tidak ditemukan.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type'=>'error','message'=>'Data pelanggan gagal dihapus.'];
}

header('Location: list.php'); exit;
