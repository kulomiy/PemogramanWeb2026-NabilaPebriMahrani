<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Memastikan base url fleksibel baik diakses dari folder utama maupun subfolder
if (file_exists('includes/header.php') || (isset($_SERVER['SCRIPT_FILENAME']) && realpath(dirname($_SERVER['SCRIPT_FILENAME'])) === realpath(__DIR__ . '/..'))) {
    $baseUrl = './';
} else {
    $baseUrl = '../';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $pageTitle ?? '<title>CamRent Studio</title>' ?>
    <!-- Jalur CSS menjadi otomatis aman di halaman mana saja -->
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style.css">
</head>
<body>
    <header class="top-header">
        <div class="header-left">
            <span class="subtitle">SISTEM MANAJEMEN RENTAL</span>
            <h1>CamRent Studio</h1>
        </div>

        <div class="header-right" style="border-left: none; padding-left: 0;">
            <?php if (basename($_SERVER['SCRIPT_NAME']) === 'about.php' || (isset($isAboutPage) && $isAboutPage)): ?>
                <a href="<?= $baseUrl ?>index.php" class="header-about-btn-large">← DASHBOARD</a>
            <?php else: ?>
                <a href="<?= $baseUrl ?>about.php" class="header-about-btn-large">ABOUT US ↗</a>
            <?php endif; ?>
        </div>
    </header>

    <?php if (!isset($showNav) || $showNav === true): ?>
    <nav class="main-nav">
        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="nav-toggle-label">
            <span>☰ Menu</span>
        </label>
        <ul>
            <!-- Link menu diperbaiki dengan menghapus penulisan folder ganda -->
            <li><a href="<?= $baseUrl ?>index.php">Dashboard</a></li>
            <li><a href="<?= $baseUrl ?>kamera/list.php">Data Kamera</a></li>
            <li><a href="<?= $baseUrl ?>kamera/tambah.php">Tambah Kamera</a></li>
            <li><a href="<?= $baseUrl ?>pelanggan/list.php">Data Pelanggan</a></li>
            <li><a href="<?= $baseUrl ?>pelanggan/tambah.php">Tambah Pelanggan</a></li>
            <li><a href="<?= $baseUrl ?>login.php">Keluar</a></li>
        </ul>
    </nav>
    <?php endif; ?>
</body>
</html>