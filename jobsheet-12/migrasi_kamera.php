<?php
session_start();
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/koneksi.php';

$jsonFile = __DIR__ . '/data/kamera.json';

if (!file_exists($jsonFile)) {
    die('File data/kamera.json tidak ditemukan.');
}

$json = file_get_contents($jsonFile);
$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
    die('Format JSON tidak valid.');
}

$berhasil = 0;
$dilewati = 0;
$gagal = 0;
$pesanGagal = [];

$sql = "INSERT INTO kamera (nama_alat, merek, tahun_beli, sn, stok, kategori)
        SELECT :nama_alat, :merek, :tahun_beli, :sn, :stok, :kategori
        FROM DUAL
        WHERE NOT EXISTS (
            SELECT 1 FROM kamera
            WHERE nama_alat = :cek_nama
              AND merek = :cek_merek
              AND tahun_beli = :cek_tahun
              AND COALESCE(sn, '') = COALESCE(:cek_sn, '')
        )";

try {
    $stmt = $pdo->prepare($sql);

    foreach ($data as $index => $item) {
        // Nama key utama mengikuti struktur CamRent.
        $nama_alat = trim($item['nama_alat'] ?? $item['nama'] ?? '');
        $merek     = trim($item['merek'] ?? '');
        $tahun     = (int)($item['tahun_beli'] ?? $item['tahun'] ?? 0);
        $sn        = trim($item['sn'] ?? $item['serial_number'] ?? '');
        $stok      = (int)($item['stok'] ?? 0);
        $kategori  = trim($item['kategori'] ?? '');

        if ($nama_alat === '' || $merek === '' || $tahun === 0 || $kategori === '') {
            $gagal++;
            $pesanGagal[] = 'Data ke-' . ($index + 1) . ' tidak lengkap.';
            continue;
        }

        $stmt->execute([
            ':nama_alat' => $nama_alat,
            ':merek'     => $merek,
            ':tahun_beli'=> $tahun,
            ':sn'        => $sn !== '' ? $sn : null,
            ':stok'      => $stok,
            ':kategori'  => $kategori,
            ':cek_nama'  => $nama_alat,
            ':cek_merek' => $merek,
            ':cek_tahun' => $tahun,
            ':cek_sn'    => $sn !== '' ? $sn : null
        ]);

        if ($stmt->rowCount() > 0) {
            $berhasil++;
        } else {
            $dilewati++;
        }
    }
} catch (PDOException $e) {
    die('Migrasi gagal: ' . e($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CamRent | Migrasi Data</title>
</head>
<body>
    <h1>Migrasi Data Kamera Selesai</h1>
    <p>Data berhasil dimasukkan: <strong><?= $berhasil ?></strong></p>
    <p>Data dilewati karena sudah ada: <strong><?= $dilewati ?></strong></p>
    <p>Data gagal: <strong><?= $gagal ?></strong></p>

    <?php if (!empty($pesanGagal)): ?>
        <h3>Detail:</h3>
        <ul>
            <?php foreach ($pesanGagal as $pesan): ?>
                <li><?= e($pesan) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="kamera/list.php">Kembali ke Data Kamera</a></p>
</body>
</html>
