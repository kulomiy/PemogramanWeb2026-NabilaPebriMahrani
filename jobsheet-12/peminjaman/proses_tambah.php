<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
require_once __DIR__ . '/../includes/csrf.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$pelangganId = filter_input(INPUT_POST, 'pelanggan_id', FILTER_VALIDATE_INT);
$kameraId = filter_input(INPUT_POST, 'kamera_id', FILTER_VALIDATE_INT);

if (!$pelangganId || !$kameraId) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Pelanggan dan kamera wajib dipilih.'];
    header('Location: tambah.php');
    exit;
}

try {
    // Satu transaction: insert peminjaman + kurangi stok harus berhasil bersama-sama.
    $pdo->beginTransaction();

    // Kunci baris kamera selama transaksi agar stok tidak terambil dua kali.
    $stmtKamera = $pdo->prepare("SELECT id, nama_alat, stok FROM kamera WHERE id = :id FOR UPDATE");
    $stmtKamera->execute([':id' => $kameraId]);
    $kamera = $stmtKamera->fetch();

    if (!$kamera) {
        throw new RuntimeException('Data kamera tidak ditemukan.');
    }

    if ((int)$kamera['stok'] <= 0) {
        throw new RuntimeException('Stok kamera sudah habis. Silakan pilih kamera lain.');
    }

    $stmtPelanggan = $pdo->prepare("SELECT id FROM pelanggan WHERE id = :id");
    $stmtPelanggan->execute([':id' => $pelangganId]);
    if (!$stmtPelanggan->fetch()) {
        throw new RuntimeException('Data pelanggan tidak ditemukan.');
    }

    $stmtInsert = $pdo->prepare("INSERT INTO peminjaman (pelanggan_id, kamera_id, status) VALUES (:pelanggan_id, :kamera_id, 'dipinjam')");
    $stmtInsert->execute([
        ':pelanggan_id' => $pelangganId,
        ':kamera_id' => $kameraId
    ]);

    $stmtStok = $pdo->prepare("UPDATE kamera SET stok = stok - 1 WHERE id = :id AND stok > 0");
    $stmtStok->execute([':id' => $kameraId]);

    if ($stmtStok->rowCount() !== 1) {
        throw new RuntimeException('Stok kamera gagal diperbarui.');
    }

    $pdo->commit();

    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => 'Peminjaman berhasil dibuat dan stok kamera telah dikurangi.'
    ];
    header('Location: kembali.php');
    exit;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Peminjaman gagal: ' . $e->getMessage()
    ];
    header('Location: tambah.php');
    exit;
}
