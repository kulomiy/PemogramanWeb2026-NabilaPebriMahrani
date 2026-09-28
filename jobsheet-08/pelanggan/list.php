<?php
$pageTitle = '<title>CamRent | Data Pelanggan</title>';
include '../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

// PERUBAHAN JOBSHEET 8: Fetch data pelanggan langsung dari database PostgreSQL
try {
    $stmt = $pdo->query("SELECT * FROM pelanggan ORDER BY id DESC");
    $daftarPelanggan = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $daftarPelanggan = [];
    $errorDb = "Gagal memuat data pelanggan dari database: " . $e->getMessage();
}
?>
<main>
    <section class="content-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 class="section-title">Daftar Pelanggan</h2>
            <a href="tambah.php" class="btn-tambah">+ Registrasi Pelanggan</a>
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
                        <th>ID REG</th>
                        <th>NAMA LENGKAP</th>
                        <th>NO. KTP</th>
                        <th>NO. HP (WA)</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarPelanggan)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #888; padding: 2rem;">
                                Belum ada data pelanggan di database. Silakan klik tombol <strong>+ Registrasi Pelanggan</strong> di atas.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarPelanggan as $item): ?>
                        <!-- PERUBAHAN JOBSHEET 8: Kolom id disimpan di baris tabel & tombol aksi untuk edit/hapus -->
                        <tr data-id="<?= htmlspecialchars($item['id']) ?>">
                            <td><strong><?= htmlspecialchars($item['id_reg']) ?></strong></td>
                            <td><?= htmlspecialchars($item['nama_lengkap']) ?></td>
                            <td><?= htmlspecialchars($item['no_ktp']) ?></td>
                            <td><?= htmlspecialchars($item['no_hp']) ?></td>
                            <td>
                                <?php
                                $isVerified = ($item['status'] ?? '') === 'Terverifikasi';
                                $bgBadge    = $isVerified ? '#efe5e5' : '#fce4e4';
                                $colorBadge = $isVerified ? '#4a121a' : '#5c1d24';
                                ?>
                                <span style="
                                    background-color: <?= $bgBadge ?>;
                                    color: <?= $colorBadge ?>;
                                    border-radius: 12px;
                                    padding: 5px 10px;
                                    font-size: 0.75rem;
                                    display: inline-block;
                                    line-height: 1.2;
                                "><?= htmlspecialchars($item['status'] ?? 'Proses Cek') ?></span>
                            </td>
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

            <p id="pelanggan-counter" style="text-align: center; margin-top: 1rem; font-size: 0.85rem; color: #A1777E;">
                Menampilkan <?= count($daftarPelanggan) ?> Total Pelanggan
            </p>
        </div>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
