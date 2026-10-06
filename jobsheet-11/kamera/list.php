<?php
$pageTitle = '<title>CamRent | Data Alat</title>';
include '../includes/header.php';
require_once __DIR__ . '/../includes/koneksi.php';

$keyword = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 5;
$offset = ($page - 1) * $perPage;

try {
    // Hitung jumlah data sesuai pencarian untuk pagination.
    if ($keyword !== '') {
        $countSql = "SELECT COUNT(*) FROM kamera
                     WHERE nama_alat LIKE :keyword
                        OR merek LIKE :keyword
                        OR kategori LIKE :keyword";
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute([':keyword' => '%' . $keyword . '%']);
    } else {
        $countStmt = $pdo->query("SELECT COUNT(*) FROM kamera");
    }

    $totalData = (int)$countStmt->fetchColumn();
    $totalPages = max(1, (int)ceil($totalData / $perPage));

    if ($page > $totalPages) {
        $page = $totalPages;
        $offset = ($page - 1) * $perPage;
    }

    // Search server-side + pagination menggunakan LIMIT/OFFSET.
    if ($keyword !== '') {
        $sql = "SELECT * FROM kamera
                WHERE nama_alat LIKE :keyword
                   OR merek LIKE :keyword
                   OR kategori LIKE :keyword
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM kamera
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $daftarKamera = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $daftarKamera = [];
    $totalData = 0;
    $totalPages = 1;
    $errorDb = 'Gagal memuat data dari database.';
}
?>
<main>
    <section class="content-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 class="section-title">Daftar Alat & Kamera</h2>
            <a href="tambah.php" class="btn-tambah">+ Tambah Alat</a>
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
            <input
                type="search"
                name="q"
                value="<?= e($keyword) ?>"
                placeholder="Cari nama alat, merek, atau kategori..."
                style="flex: 1; min-width: 250px; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px;"
            >
            <button type="submit">Cari</button>
            <?php if ($keyword !== ''): ?>
                <a href="list.php" style="text-decoration: none;">Reset</a>
            <?php endif; ?>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NAMA ALAT</th>
                        <th>MEREK</th>
                        <th>TAHUN BELI</th>
                        <th>STOK</th>
                        <th>TANGGAL DITAMBAHKAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarKamera)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #888; padding: 2rem;">
                                <?= $keyword !== ''
                                    ? 'Data kamera dengan kata kunci <strong>' . e($keyword) . '</strong> tidak ditemukan.'
                                    : 'Belum ada data kamera di database. Silakan klik tombol <strong>+ Tambah Alat</strong> di atas.' ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarKamera as $item): ?>
                        <tr>
                            <td>
                                <strong><?= e($item['nama_alat']) ?></strong>
                                <?php if (!empty($item['kategori'])): ?>
                                    <br><small style="color: #888; font-size: 0.75rem; text-transform: uppercase;">[<?= e($item['kategori']) ?>]</small>
                                <?php endif; ?>
                            </td>
                            <td><?= e($item['merek']) ?></td>
                            <td><?= e($item['tahun_beli']) ?></td>
                            <td><?= e($item['stok']) ?></td>
                            <td><?= !empty($item['created_at']) ? e(date('d-m-Y H:i', strtotime($item['created_at']))) : '-' ?></td>
                            <td>
                                <a href="edit.php?id=<?= urlencode($item['id']) ?>" class="btn-aksi btn-edit">Edit</a>
                                <form action="hapus.php" method="post" class="form-hapus" style="display: inline;">
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

            <p style="text-align: center; margin-top: 1rem; font-size: 0.85rem; color: #A1777E;">
                Menampilkan <?= count($daftarKamera) ?> dari <?= $totalData ?> data kamera
            </p>

            <?php if ($totalPages > 1): ?>
                <div class="pagination" style="display:flex; justify-content:center; gap:0.5rem; margin-top:1rem; flex-wrap:wrap;">
                    <?php if ($page > 1): ?>
                        <a href="?<?= http_build_query(['q'=>$keyword, 'page'=>$page-1]) ?>">← Sebelumnya</a>
                    <?php endif; ?>
                    <?php for ($i=1; $i <= $totalPages; $i++): ?>
                        <a href="?<?= http_build_query(['q'=>$keyword, 'page'=>$i]) ?>"
                           style="padding:0.4rem 0.7rem; border-radius:6px; text-decoration:none; <?= $i === $page ? 'font-weight:bold; text-decoration:underline;' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="?<?= http_build_query(['q'=>$keyword, 'page'=>$page+1]) ?>">Berikutnya →</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include '../includes/footer.php'; ?>
