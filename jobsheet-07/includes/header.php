<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Logika dinamis untuk mendeteksi jalur folder dasar proyek Anda secara akurat
$currentScript = $_SERVER['SCRIPT_NAME']; 
$scriptDir = dirname($currentScript);

// Memastikan base url fleksibel baik diakses dari folder utama maupun subfolder
if ($scriptDir === '/Prak-PemrogWeb/jobsheet-07' || $scriptDir === '/Prak-PemrogWeb/jobsheet-07/') {
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
            <a href="<?= $baseUrl ?>about.php" class="header-about-btn-large">ABOUT US ↗</a>
        </div>
    </header>

    <?php if (!isset($showNav) || $showNav === true): ?>
    <nav class="main-nav">
        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="nav-toggle-label">
            <span>☰ Menu</span>
        </label>
        <ul>
            <!-- Link menu otomatis menyesuaikan posisi file secara dinamis -->
            <li><a href="<?= $baseUrl ?>index.php">Dashboard</a></li>
            <li><a href="<?= $baseUrl ?>kamera/list.php">Data Kamera</a></li>
            <li><a href="<?= $baseUrl ?>kamera/tambah.php">Tambah Kamera</a></li>
            <li><a href="<?= $baseUrl ?>pelanggan/list.php">Data Pelanggan</a></li>
            <li><a href="<?= $baseUrl ?>pelanggan/tambah.php">Tambah Pelanggan</a></li>
            <li><a href="<?= $baseUrl ?>login.php">Keluar</a></li>
        </ul>
    </nav>
    <?php endif; ?>
