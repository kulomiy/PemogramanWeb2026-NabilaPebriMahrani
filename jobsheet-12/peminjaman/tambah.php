<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';
$pageTitle = '<title>CamRent | Peminjaman Baru</title>';
include '../includes/header.php';

$pelanggan = [];
$kamera = [];
$errorDb = null;

try {
    $stmtPelanggan = $pdo->query("SELECT id, id_reg, nama_lengkap FROM pelanggan ORDER BY nama_lengkap ASC");
    $pelanggan = $stmtPelanggan->fetchAll();

    $stmtKamera = $pdo->query("SELECT id, nama_alat, merek, stok FROM kamera WHERE stok > 0 ORDER BY nama_alat ASC");
    $kamera = $stmtKamera->fetchAll();
} catch (PDOException $e) {
    $errorDb = 'Gagal memuat data pelanggan atau kamera.';
}
?>
<main>
    <section class="content-box">
        <h2 class="section-title">Peminjaman Kamera Baru</h2>
        <p class="section-desc">Pilih pelanggan dan kamera yang tersedia untuk membuat transaksi peminjaman.</p>
        <hr class="divider">

        <?php if ($errorDb): ?>
            <div class="flash-message error"><?= e($errorDb) ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?= e($_SESSION['flash']['type']) ?>">
                <?= e($_SESSION['flash']['message']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="proses_tambah.php" method="post" style="max-width: 600px; margin-top: 1.5rem;">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="pelanggan_id">Pelanggan</label>
                <select id="pelanggan_id" name="pelanggan_id" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php foreach ($pelanggan as $item): ?>
                        <option value="<?= e($item['id']) ?>">
                            <?= e($item['id_reg']) ?> - <?= e($item['nama_lengkap']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="kamera_id">Kamera / Alat</label>
                <select id="kamera_id" name="kamera_id" required>
                    <option value="">-- Pilih Kamera yang Tersedia --</option>
                    <?php foreach ($kamera as $item): ?>
                        <option value="<?= e($item['id']) ?>">
                            <?= e($item['nama_alat']) ?> - <?= e($item['merek']) ?> (stok: <?= e($item['stok']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (empty($kamera)): ?>
                    <small style="color:#9B2C2C;">Tidak ada kamera dengan stok tersedia.</small>
                <?php endif; ?>
            </div>

            <button type="submit" style="margin-top: 1rem;" <?= empty($kamera) || empty($pelanggan) ? 'disabled' : '' ?>>Simpan Peminjaman</button>
            <a href="kembali.php" style="margin-left: 0.75rem;">Lihat Peminjaman Aktif</a>
        </form>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
