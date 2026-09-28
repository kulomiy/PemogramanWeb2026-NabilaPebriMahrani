<?php
$pageTitle = '<title>CamRent | Data Alat</title>';
include '../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

// PERUBAHAN JOBSHEET 8: Fetch data langsung dari database PostgreSQL
try {
    $stmt = $pdo->query("SELECT * FROM kamera ORDER BY id DESC");
    $daftarKamera = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $daftarKamera = [];
    $errorDb = "Gagal memuat data dari database: " . $e->getMessage();
}
?>
<main>
    <section class="content-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 class="section-title">Daftar Alat & Kamera</h2>
            <a href="tambah.php" class="btn-tambah">+ Tambah Alat</a>
        </div>

        <!-- Flash Message untuk notifikasi sukses/gagal -->
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-message <?= htmlspecialchars($_SESSION['flash']['type']) ?>">
                <?= htmlspecialchars($_SESSION['flash']['message']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php if (isset($errorDb)): ?>
            <div class="flash-message error">
                <?= htmlspecialchars($errorDb) ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NAMA ALAT</th>
                        <th>MEREK</th>
                        <th>TAHUN BELI</th>
                        <th>STOK</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarKamera)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888; padding: 2rem;">
                                Belum ada data kamera di database. Silakan klik tombol <strong>+ Tambah Alat</strong> di atas.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarKamera as $item): ?>
                        <!-- PERUBAHAN JOBSHEET 8: Kolom id disimpan di baris data & tombol aksi untuk edit/hapus -->
                        <tr data-id="<?= htmlspecialchars($item['id']) ?>">
                            <td>
                                <strong><?= htmlspecialchars($item['nama_alat']) ?></strong>
                                <?php if (!empty($item['kategori'])): ?>
                                    <br><small style="color: #888; font-size: 0.75rem; text-transform: uppercase;">[<?= htmlspecialchars($item['kategori']) ?>]</small>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($item['merek']) ?></td>
                            <td><?= htmlspecialchars($item['tahun_beli']) ?></td>
                            <td><?= htmlspecialchars($item['stok']) ?></td>
                            <td>
                                <!-- Kolom ID disimpan di atribut data-id pada tombol aksi -->
                                <button type="button" class="btn-aksi btn-edit" data-id="<?= htmlspecialchars($item['id']) ?>">Edit</button>
                                <button type="button" class="btn-aksi btn-hapus" data-id="<?= htmlspecialchars($item['id']) ?>">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <p id="kamera-counter" style="text-align: center; margin-top: 1rem; font-size: 0.85rem; color: #A1777E;">
                Total Jenis Alat: <?= count($daftarKamera) ?>
            </p>
        </div>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
