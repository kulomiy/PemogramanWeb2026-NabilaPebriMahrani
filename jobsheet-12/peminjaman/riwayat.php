<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
$pageTitle = '<title>CamRent | Riwayat Peminjaman</title>';
include '../includes/header.php';

$keyword = trim($_GET['q'] ?? '');

try {
    $sql = "SELECT p.id, p.tanggal_pinjam, p.tanggal_kembali, p.status,
                   pl.id_reg, pl.nama_lengkap,
                   k.nama_alat, k.merek
            FROM peminjaman p
            INNER JOIN pelanggan pl ON pl.id = p.pelanggan_id
            INNER JOIN kamera k ON k.id = p.kamera_id";

    if ($keyword !== '') {
        $sql .= " WHERE pl.nama_lengkap LIKE :keyword
                    OR pl.id_reg LIKE :keyword
                    OR k.nama_alat LIKE :keyword
                    OR k.merek LIKE :keyword";
    }

    $sql .= " ORDER BY p.tanggal_pinjam DESC";
    $stmt = $pdo->prepare($sql);
    if ($keyword !== '') {
        $stmt->execute([':keyword' => '%' . $keyword . '%']);
    } else {
        $stmt->execute();
    }
    $riwayat = $stmt->fetchAll();
} catch (PDOException $e) {
    $riwayat = [];
    $errorDb = 'Gagal memuat riwayat peminjaman.';
}
?>
<main>
    <section class="content-box">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
            <div>
                <h2 class="section-title">Riwayat Peminjaman</h2>
                <p class="section-desc">Histori transaksi peminjaman kamera berdasarkan data pelanggan dan kamera.</p>
            </div>
            <a href="tambah.php" class="btn-tambah">+ Peminjaman Baru</a>
        </div>

        <form method="get" action="riwayat.php" style="display:flex; gap:0.75rem; margin-bottom:1.5rem; align-items:center; flex-wrap:wrap;">
            <input type="search" name="q" value="<?= e($keyword) ?>" placeholder="Cari pelanggan atau kamera..." style="flex:1; min-width:250px; padding:0.75rem; border:1px solid #ddd; border-radius:8px;">
            <button type="submit">Cari</button>
            <?php if ($keyword !== ''): ?><a href="riwayat.php">Reset</a><?php endif; ?>
        </form>

        <?php if (isset($errorDb)): ?>
            <div class="flash-message error"><?= e($errorDb) ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>PELANGGAN</th>
                        <th>KAMERA</th>
                        <th>TANGGAL PINJAM</th>
                        <th>TANGGAL KEMBALI</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr><td colspan="5" style="text-align:center; padding:2rem; color:#888;">Belum ada riwayat peminjaman.</td></tr>
                    <?php else: ?>
                        <?php foreach ($riwayat as $item): ?>
                            <tr>
                                <td><strong><?= e($item['nama_lengkap']) ?></strong><br><small><?= e($item['id_reg']) ?></small></td>
                                <td><?= e($item['nama_alat']) ?> <small>(<?= e($item['merek']) ?>)</small></td>
                                <td><?= e(date('d-m-Y H:i', strtotime($item['tanggal_pinjam']))) ?></td>
                                <td><?= $item['tanggal_kembali'] ? e(date('d-m-Y H:i', strtotime($item['tanggal_kembali']))) : '-' ?></td>
                                <td><span class="flash-message <?= $item['status'] === 'dipinjam' ? 'error' : 'success' ?>" style="display:inline-block; padding:0.35rem 0.6rem; margin:0;"><?= e(ucfirst($item['status'])) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
