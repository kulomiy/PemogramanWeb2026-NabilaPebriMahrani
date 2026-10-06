<?php
require_once __DIR__ . '/../includes/auth.php';
$pageTitle = '<title>CamRent | Data Pelanggan</title>';
include '../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$keyword = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 5;
$offset = ($page - 1) * $perPage;

try {
    if ($keyword !== '') {
        $countSql = "SELECT COUNT(*) FROM pelanggan
                     WHERE id_reg LIKE :keyword
                        OR nama_lengkap LIKE :keyword
                        OR no_hp LIKE :keyword
                        OR status LIKE :keyword";
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute([':keyword'=>'%' . $keyword . '%']);
    } else {
        $countStmt = $pdo->query('SELECT COUNT(*) FROM pelanggan');
    }

    $totalData = (int)$countStmt->fetchColumn();
    $totalPages = max(1, (int)ceil($totalData / $perPage));

    if ($page > $totalPages) {
        $page = $totalPages;
        $offset = ($page - 1) * $perPage;
    }

    if ($keyword !== '') {
        $sql = "SELECT * FROM pelanggan
                WHERE id_reg LIKE :keyword
                   OR nama_lengkap LIKE :keyword
                   OR no_hp LIKE :keyword
                   OR status LIKE :keyword
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare('SELECT * FROM pelanggan ORDER BY id DESC LIMIT :limit OFFSET :offset');
    }

    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $daftarPelanggan = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $daftarPelanggan = [];
    $totalData = 0;
    $totalPages = 1;
    $errorDb = 'Gagal memuat data pelanggan dari database.';
}
?>
<main>
    <section class="content-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 class="section-title">Daftar Pelanggan</h2>
            <a href="tambah.php" class="btn-tambah">+ Registrasi Pelanggan</a>
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

        <!-- Jobsheet 9: pencarian server-side -->
        <form method="get" action="list.php" style="display: flex; gap: 0.75rem; margin-bottom: 1.5rem; align-items: center; flex-wrap: wrap;">
            <input type="search" name="q" value="<?= e($keyword) ?>"
                   placeholder="Cari ID registrasi, nama, no. HP, atau status..."
                   style="flex:1; min-width:250px; padding:0.75rem; border:1px solid #ddd; border-radius:8px;">
            <button type="submit">Cari</button>
            <?php if ($keyword !== ''): ?><a href="list.php" style="text-decoration:none;">Reset</a><?php endif; ?>
        </form>

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
                        <tr><td colspan="6" style="text-align:center;color:#888;padding:2rem;">
                            <?= $keyword !== '' ? 'Data pelanggan dengan kata kunci <strong>' . e($keyword) . '</strong> tidak ditemukan.' : 'Belum ada data pelanggan di database. Silakan klik tombol <strong>+ Registrasi Pelanggan</strong> di atas.' ?>
                        </td></tr>
                    <?php else: ?>
                        <?php foreach ($daftarPelanggan as $item): ?>
                        <tr>
                            <td><strong><?= e($item['id_reg']) ?></strong></td>
                            <td><?= e($item['nama_lengkap']) ?></td>
                            <td><?= e($item['no_ktp']) ?></td>
                            <td><?= e($item['no_hp']) ?></td>
                            <td>
                                <?php $isVerified = ($item['status'] ?? '') === 'Terverifikasi'; ?>
                                <span style="background-color:<?= $isVerified ? '#efe5e5' : '#fce4e4' ?>;color:<?= $isVerified ? '#4a121a' : '#5c1d24' ?>;border-radius:12px;padding:5px 10px;font-size:.75rem;display:inline-block;line-height:1.2;">
                                    <?= e($item['status'] ?? 'Proses Cek') ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= urlencode($item['id']) ?>" class="btn-aksi btn-edit">Edit</a>
                                <form action="hapus.php" method="post" class="form-hapus" style="display:inline;">
                <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= e($item['id']) ?>">
                                    <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <p style="text-align:center;margin-top:1rem;font-size:.85rem;color:#A1777E;">Menampilkan <?= count($daftarPelanggan) ?> dari <?= $totalData ?> total pelanggan</p>

            <?php if ($totalPages > 1): ?>
                <div class="pagination" style="display:flex;justify-content:center;gap:.5rem;margin-top:1rem;flex-wrap:wrap;">
                    <?php if ($page > 1): ?><a href="?<?= http_build_query(['q'=>$keyword,'page'=>$page-1]) ?>">← Sebelumnya</a><?php endif; ?>
                    <?php for ($i=1; $i <= $totalPages; $i++): ?>
                        <a href="?<?= http_build_query(['q'=>$keyword,'page'=>$i]) ?>" style="padding:.4rem .7rem;border-radius:6px;text-decoration:none;<?= $i === $page ? 'font-weight:bold;text-decoration:underline;' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?><a href="?<?= http_build_query(['q'=>$keyword,'page'=>$page+1]) ?>">Berikutnya →</a><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
