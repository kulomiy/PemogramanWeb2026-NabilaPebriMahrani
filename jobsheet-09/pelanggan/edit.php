<?php
$pageTitle = '<title>CamRent | Edit Pelanggan</title>';
include '../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['flash'] = ['type'=>'error','message'=>'ID pelanggan tidak valid.'];
    header('Location: list.php'); exit;
}

try {
    $stmt = $pdo->prepare('SELECT * FROM pelanggan WHERE id = :id');
    $stmt->execute([':id'=>$id]);
    $pelanggan = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$pelanggan) {
        $_SESSION['flash'] = ['type'=>'error','message'=>'Data pelanggan tidak ditemukan.'];
        header('Location: list.php'); exit;
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type'=>'error','message'=>'Gagal mengambil data pelanggan.'];
    header('Location: list.php'); exit;
}
?>
<main>
    <section class="content-box">
        <h2 class="section-title">Edit Data Pelanggan</h2>
        <hr class="divider">
        <form action="proses_edit.php" method="post" style="max-width:600px;margin-top:1.5rem;">
            <input type="hidden" name="id" value="<?= htmlspecialchars($pelanggan['id']) ?>">
            <div class="form-group">
                <label for="id_reg">ID Registrasi</label>
                <input type="text" id="id_reg" name="id_reg" value="<?= htmlspecialchars($pelanggan['id_reg']) ?>" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama Lengkap Sesuai KTP</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($pelanggan['nama_lengkap']) ?>" required>
            </div>
            <div class="form-group">
                <label for="no_ktp">Nomor Identitas (KTP/SIM)</label>
                <input type="text" id="no_ktp" name="no_ktp" value="<?= htmlspecialchars($pelanggan['no_ktp']) ?>" required>
            </div>
            <div class="form-group">
                <label for="no_wa">Nomor HP (WhatsApp)</label>
                <input type="tel" id="no_wa" name="no_wa" value="<?= htmlspecialchars($pelanggan['no_hp']) ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Domisili</label>
                <textarea id="alamat" name="alamat" rows="2" required><?= htmlspecialchars($pelanggan['alamat']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <?php foreach (['Proses Cek','Terverifikasi'] as $status): ?>
                        <option value="<?= $status ?>" <?= ($pelanggan['status'] ?? '') === $status ? 'selected' : '' ?>><?= $status ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" style="margin-top:1rem;">Simpan Perubahan</button>
            <a href="list.php" style="margin-left:.75rem;">Batal</a>
        </form>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
