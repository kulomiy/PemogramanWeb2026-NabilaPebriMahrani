<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
$pageTitle = '<title>CamRent | Pengembalian</title>';
include '../includes/header.php';

try {
    $sql = "SELECT p.id, p.tanggal_pinjam,
                   pl.id_reg, pl.nama_lengkap,
                   k.nama_alat, k.merek
            FROM peminjaman p
            INNER JOIN pelanggan pl ON pl.id = p.pelanggan_id
            INNER JOIN kamera k ON k.id = p.kamera_id
            WHERE p.status = 'dipinjam'
            ORDER BY p.tanggal_pinjam DESC";
    $stmt = $pdo->query($sql);
    $peminjamanAktif = $stmt->fetchAll();
} catch (PDOException $e) {
    $peminjamanAktif = [];
    $errorDb = 'Gagal memuat data peminjaman aktif.';
}
?>
<main>
    <section class="content-box">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
            <div>
                <h2 class="section-title">Pengembalian Kamera</h2>
                <p class="section-desc">Daftar kamera yang saat ini masih dipinjam.</p>
            </div>
            <a href="tambah.php" class="btn-tambah">+ Peminjaman Baru</a>
        </div>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?= e($_SESSION['flash']['type']) ?>">
                <?= e($_SESSION['flash']['message']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

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
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjamanAktif)): ?>
                        <tr><td colspan="4" style="text-align:center; padding:2rem; color:#888;">Tidak ada transaksi yang sedang dipinjam.</td></tr>
                    <?php else: ?>
                        <?php foreach ($peminjamanAktif as $item): ?>
                            <tr>
                                <td><strong><?= e($item['nama_lengkap']) ?></strong><br><small><?= e($item['id_reg']) ?></small></td>
                                <td><?= e($item['nama_alat']) ?> <small>(<?= e($item['merek']) ?>)</small></td>
                                <td><?= e(date('d-m-Y H:i', strtotime($item['tanggal_pinjam']))) ?></td>
                                <td>
                                    <form action="proses_kembali.php" method="post" style="display:inline;" onsubmit="return confirm('Yakin kamera ini dikembalikan?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= e($item['id']) ?>">
                                        <button type="submit" class="btn-aksi btn-edit">Kembalikan</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
