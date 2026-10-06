<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/csrf.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kembali.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'ID peminjaman tidak valid.'];
    header('Location: kembali.php');
    exit;
}

try {
    // Satu transaction: ambil transaksi + kunci kamera + tambah stok + ubah status.
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT id, kamera_id, status FROM peminjaman WHERE id = :id FOR UPDATE");
    $stmt->execute([':id' => $id]);
    $peminjaman = $stmt->fetch();

    if (!$peminjaman) {
        throw new RuntimeException('Transaksi peminjaman tidak ditemukan.');
    }

    if ($peminjaman['status'] !== 'dipinjam') {
        throw new RuntimeException('Transaksi ini sudah dikembalikan.');
    }

    $stmtKamera = $pdo->prepare("SELECT id FROM kamera WHERE id = :id FOR UPDATE");
    $stmtKamera->execute([':id' => $peminjaman['kamera_id']]);
    if (!$stmtKamera->fetch()) {
        throw new RuntimeException('Data kamera tidak ditemukan.');
    }

    $stmtStok = $pdo->prepare("UPDATE kamera SET stok = stok + 1 WHERE id = :id");
    $stmtStok->execute([':id' => $peminjaman['kamera_id']]);

    $stmtUpdate = $pdo->prepare("UPDATE peminjaman SET status = 'dikembalikan', tanggal_kembali = CURRENT_TIMESTAMP WHERE id = :id");
    $stmtUpdate->execute([':id' => $id]);

    $pdo->commit();

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Kamera berhasil dikembalikan dan stok telah ditambahkan kembali.'
    ];
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pengembalian gagal: ' . $e->getMessage()];
}

header('Location: kembali.php');
exit;
