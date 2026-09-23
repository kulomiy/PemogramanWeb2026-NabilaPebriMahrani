<?php
$pageTitle = '<title>CamRent | Tambah Pelanggan</title>';
include '../includes/header.php';

$anggota = $_SESSION['anggota'] ?? [];
$nextNumber = count($anggota) + 1;
$nextId = 'P-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
?>
<main>
        <section class="content-box">
            <h2 class="section-title">Registrasi Pelanggan Baru</h2>
            <hr class="divider">
            <form action="proses_tambah.php" method="post" style="max-width: 600px; margin-top: 1.5rem;">
                <div class="form-group">
                    <label for="id_reg">ID Registrasi</label>
                    <input type="text" id="id_reg" name="id_reg" value="<?= htmlspecialchars($nextId) ?>" readonly style="background-color: #e2e8f0; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap Sesuai KTP</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="no_ktp">Nomor Identitas (KTP/SIM)</label>
                    <input type="number" id="no_ktp" name="no_ktp" required>
                </div>
                <div class="form-group">
                    <label for="no_wa">Nomor HP (WhatsApp)</label>
                    <input type="tel" id="no_wa" name="no_wa" placeholder="Contoh: 0812..." required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Domisili</label>
                    <textarea id="alamat" name="alamat" rows="2" required></textarea>
                </div>
                <button type="submit" style="margin-top: 1rem;">Simpan Data Pelanggan</button>
            </form>
        </section>
    </main>
<?php include '../includes/footer.php'; ?>
