<?php
$pageTitle = '<title>CamRent | Data Alat</title>';
include '../includes/header.php';

if (!isset($_SESSION['kamera'])) {
    $_SESSION['kamera'] = [
        [
            'nama_alat' => 'Alpha A7 Mark III',
            'merek' => 'Sony',
            'tahun_beli' => 2021,
            'stok' => 4,
            'sn' => '',
            'kategori' => 'mirrorless'
        ],
        [
            'nama_alat' => 'EOS R6 Mark II',
            'merek' => 'Canon',
            'tahun_beli' => 2023,
            'stok' => 2,
            'sn' => '',
            'kategori' => 'mirrorless'
        ],
        [
            'nama_alat' => 'Fujifilm X-T4',
            'merek' => 'Fujifilm',
            'tahun_beli' => 2022,
            'stok' => 3,
            'sn' => '',
            'kategori' => 'mirrorless'
        ],
        [
            'nama_alat' => 'Lensa FE 24-70mm f/2.8',
            'merek' => 'Sony',
            'tahun_beli' => 2020,
            'stok' => 0,
            'sn' => '',
            'kategori' => 'lensa'
        ],
        [
            'nama_alat' => 'DJI Ronin-SC',
            'merek' => 'DJI',
            'tahun_beli' => 2022,
            'stok' => 5,
            'sn' => '',
            'kategori' => 'aksesoris'
        ]
    ];
}
?>
<main>
        <section class="content-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 class="section-title">Daftar Alat & Kamera</h2>
                <a href="tambah.php" class="btn-tambah">+ Tambah Alat</a>
            </div>

            <?php if (isset($_SESSION['flash'])): ?>
                <div class="flash-message <?= htmlspecialchars($_SESSION['flash']['type']) ?>">
                    <?= htmlspecialchars($_SESSION['flash']['message']) ?>
                </div>
                <?php unset($_SESSION['flash']); ?>
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
                    <?php foreach ($_SESSION['kamera'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama_alat']) ?></td>
                        <td><?= htmlspecialchars($item['merek']) ?></td>
                        <td><?= htmlspecialchars($item['tahun_beli']) ?></td>
                        <td><?= htmlspecialchars($item['stok']) ?></td>
                        <td>
                            <button type="button" class="btn-aksi btn-edit">Edit</button>
                            <button type="button" class="btn-aksi btn-hapus">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
             <p id="kamera-counter" style="text-align: center; margin-top: 1rem; font-size: 0.85rem; color: #A1777E;">
                Total Jenis Alat: <?= count($_SESSION['kamera']) ?>
             </p>
            </div>
        </section>
    </main>
<?php include '../includes/footer.php'; ?>
