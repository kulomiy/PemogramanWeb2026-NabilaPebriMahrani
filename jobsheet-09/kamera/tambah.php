<?php
$pageTitle = '<title>CamRent | Tambah Alat</title>';
include '../includes/header.php';
?>
<main>
        <section class="content-box">
            <h2 class="section-title">Tambah Data Alat</h2>
            <hr class="divider">
            <form action="proses_tambah.php" method="post" style="max-width: 600px; margin-top: 1.5rem;">
                <div class="form-group">
                    <label for="nama_alat">Nama Alat / Lensa</label>
                    <input type="text" id="nama_alat" name="nama_alat" placeholder="Misal: Alpha A7 Mark III" required>
                </div>
                <div class="form-group">
                    <label for="merek">Merek</label>
                    <input type="text" id="merek" name="merek" placeholder="Misal: Sony, Canon" required>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun Pembelian</label>
                    <input type="number" id="tahun" name="tahun" min="2010" max="2026" required>
                </div>
                <div class="form-group">
                    <label for="sn">Nomor Seri (SN)</label>
                    <input type="text" id="sn" name="sn" placeholder="Nomor seri unit">
                </div>
                <div class="form-group">
                    <label for="stok">Jumlah Stok</label>
                    <input type="number" id="stok" name="stok" min="0" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori Alat</label>
                    <select id="kategori" name="kategori">
                        <option value="mirrorless">Kamera Mirrorless</option>
                        <option value="dslr">Kamera DSLR</option>
                        <option value="lensa">Lensa</option>
                        <option value="aksesoris">Aksesoris</option>
                    </select>
                </div>
                <button type="submit" style="margin-top: 1rem;">Simpan Data</button>
            </form>
        </section>
    </main>
<?php include '../includes/footer.php'; ?>
