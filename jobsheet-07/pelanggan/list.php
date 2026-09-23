<?php
$pageTitle = '<title>CamRent | Data Pelanggan</title>';
include '../includes/header.php';

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [
        [
            'id_reg' => 'P-001',
            'nama_lengkap' => 'Ahmad Fauzi',
            'no_ktp' => '357301234567',
            'no_hp' => '08123456789',
            'alamat' => '',
            'status' => 'Terverifikasi'
        ],
        [
            'id_reg' => 'P-002',
            'nama_lengkap' => 'Siti Nurhaliza',
            'no_ktp' => '357309876543',
            'no_hp' => '08198765432',
            'alamat' => '',
            'status' => 'Proses Cek'
        ],
        [
            'id_reg' => 'P-003',
            'nama_lengkap' => 'Budi Santoso',
            'no_ktp' => '357311223344',
            'no_hp' => '08571234567',
            'alamat' => '',
            'status' => 'Terverifikasi'
        ],
        [
            'id_reg' => 'P-004',
            'nama_lengkap' => 'Dewi Lestari',
            'no_ktp' => '357322334455',
            'no_hp' => '08219876543',
            'alamat' => '',
            'status' => 'Terverifikasi'
        ]
    ];
}
?>
<main>
        <section class="content-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 class="section-title">Daftar Pelanggan</h2>
                <a href="tambah.php" class="btn-tambah">+ Registrasi Pelanggan</a>
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
                        <th>ID REG</th>
                        <th>NAMA LENGKAP</th>
                        <th>NO. KTP</th>
                        <th>NO. HP (WA)</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['anggota'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['id_reg']) ?></td>
                        <td><?= htmlspecialchars($item['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($item['no_ktp']) ?></td>
                        <td><?= htmlspecialchars($item['no_hp']) ?></td>
                        <td>
                            <?php
                            $isVerified = $item['status'] === 'Terverifikasi';
                            $bgBadge = $isVerified ? '#efe5e5' : '#fce4e4';
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
                            "><?= htmlspecialchars($item['status']) ?></span>
                        </td>
                        <td>
                            <button type="button" class="btn-aksi btn-edit">Edit</button>
                            <button type="button" class="btn-aksi btn-hapus">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
             <p id="pelanggan-counter" style="text-align: center; margin-top: 1rem; font-size: 0.85rem; color: #A1777E;">
                Menampilkan <?= count($_SESSION['anggota']) ?> dari 156 Total Pelanggan
             </p>
            </div>
        </section>
    </main>
<?php include '../includes/footer.php'; ?>
