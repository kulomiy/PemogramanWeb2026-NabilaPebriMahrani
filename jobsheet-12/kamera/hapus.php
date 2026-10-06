<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/csrf.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['flash'] = ['type'=>'error', 'message'=>'ID kamera tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM kamera WHERE id = :id');
    $stmt->execute([':id'=>$id]);

    $_SESSION['flash'] = $stmt->rowCount() > 0
        ? ['type'=>'success', 'message'=>'Data kamera berhasil dihapus.']
        : ['type'=>'error', 'message'=>'Data kamera tidak ditemukan.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type'=>'error', 'message'=>'Data kamera gagal dihapus.'];
}

header('Location: list.php');
exit;
