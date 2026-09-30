<?php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = '<title>CamRent | Edit Alat</title>';
include '../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['flash'] = ['type'=>'error', 'message'=>'ID kamera tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT * FROM kamera WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $kamera = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$kamera) {
        $_SESSION['flash'] = ['type'=>'error', 'message'=>'Data kamera tidak ditemukan.'];
        header('Location: list.php');
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type'=>'error', 'message'=>'Gagal mengambil data kamera.'];
    header('Location: list.php');
    exit;
}
?>
<main>
    <section class="content-box">
        <h2 class="section-title">Edit Data Alat</h2>
        <hr class="divider">
        <form action="proses_edit.php" method="post" style="max-width: 600px; margin-top: 1.5rem;">
            <input type="hidden" name="id" value="<?= htmlspecialchars($kamera['id']) ?>">
            <div class="form-group">
                <label for="nama_alat">Nama Alat / Lensa</label>
                <input type="text" id="nama_alat" name="nama_alat" value="<?= htmlspecialchars($kamera['nama_alat']) ?>" required>
            </div>
            <div class="form-group">
                <label for="merek">Merek</label>
                <input type="text" id="merek" name="merek" value="<?= htmlspecialchars($kamera['merek']) ?>" required>
            </div>
            <div class="form-group">
                <label for="tahun">Tahun Pembelian</label>
                <input type="number" id="tahun" name="tahun" value="<?= htmlspecialchars($kamera['tahun_beli']) ?>" min="2010" max="2026" required>
            </div>
            <div class="form-group">
                <label for="sn">Nomor Seri (SN)</label>
                <input type="text" id="sn" name="sn" value="<?= htmlspecialchars($kamera['sn'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="stok">Jumlah Stok</label>
                <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($kamera['stok']) ?>" min="0" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori Alat</label>
                <select id="kategori" name="kategori" required>
                    <?php foreach (['mirrorless'=>'Kamera Mirrorless','dslr'=>'Kamera DSLR','lensa'=>'Lensa','aksesoris'=>'Aksesoris'] as $value=>$label): ?>
                        <option value="<?= $value ?>" <?= ($kamera['kategori'] ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" style="margin-top: 1rem;">Simpan Perubahan</button>
            <a href="list.php" style="margin-left:0.75rem;">Batal</a>
        </form>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
