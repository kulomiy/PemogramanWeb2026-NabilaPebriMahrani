<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';

// Memastikan base url fleksibel baik diakses dari folder utama maupun subfolder
if (file_exists('includes/header.php') || (isset($_SERVER['SCRIPT_FILENAME']) && realpath(dirname($_SERVER['SCRIPT_FILENAME'])) === realpath(__DIR__ . '/..'))) {
    $baseUrl = './';
} else {
    $baseUrl = '../';
}

$isLoggedIn = isset($_SESSION['user']);
$currentUser = $isLoggedIn ? $_SESSION['user'] : null;
$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $pageTitle ?? '<title>CamRent Studio</title>' ?>
    <!-- Jalur CSS fleksibel untuk root maupun subfolder -->
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style.css">
</head>
<body>
    <header class="top-header">
        <div class="header-left">
            <span class="subtitle">SISTEM MANAJEMEN RENTAL</span>
            <h1>CamRent Studio</h1>
        </div>

        <div class="header-right" style="border-left: none; padding-left: 0;">
            <?php if ($isLoggedIn): ?>
                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.35rem;">
                    <div style="text-align: right;">
                        <span style="font-size: 0.72rem; letter-spacing: 1.2px; text-transform: uppercase; color: #EADCE0; display: block;">Petugas Aktif</span>
                        <strong style="color: #ffffff; font-size: 0.92rem;">👤 <?= e($currentUser['nama_lengkap'] ?? $currentUser['username']) ?></strong>
                    </div>
                    <div style="display: flex; gap: 0.5rem; align-items: center; margin-top: 0.2rem;">
                        <a href="<?= $baseUrl ?>auth/logout.php" class="header-about-btn-large" style="padding: 0.35rem 0.85rem; font-size: 0.75rem; background: rgba(161, 119, 126, 0.35);" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">LOGOUT ↗</a>
                    </div>
                </div>
            <?php else: ?>
                <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                    <a href="<?= $baseUrl ?>auth/login.php" class="header-about-btn-large" style="padding: 0.45rem 1.1rem; font-size: 0.8rem; background: #ffffff; color: #59000A; font-weight: 700;">LOGIN PETUGAS ↗</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <?php if (!isset($showNav) || $showNav === true): ?>
    <nav class="main-nav">
        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="nav-toggle-label">
            <span>☰ Menu CamRent</span>
        </label>
        <ul>
            <li><a href="<?= $baseUrl ?>index.php" <?= $currentScript === 'index.php' ? 'class="active"' : '' ?>>Dashboard</a></li>
            <li><a href="<?= $baseUrl ?>kamera/list.php">Data Kamera</a></li>
            <li><a href="<?= $baseUrl ?>kamera/tambah.php">Tambah Kamera</a></li>
            <li><a href="<?= $baseUrl ?>pelanggan/list.php">Data Pelanggan</a></li>
            <li><a href="<?= $baseUrl ?>pelanggan/tambah.php">Tambah Pelanggan</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="<?= $baseUrl ?>peminjaman/tambah.php">Peminjaman Baru</a></li>
                <li><a href="<?= $baseUrl ?>peminjaman/kembali.php">Pengembalian</a></li>
                <li><a href="<?= $baseUrl ?>peminjaman/riwayat.php">Riwayat</a></li>
            <?php endif; ?>
            <li><a href="<?= $baseUrl ?>about.php" <?= $currentScript === 'about.php' ? 'class="active"' : '' ?>>About Us</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="<?= $baseUrl ?>auth/logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Keluar</a></li>
            <?php else: ?>
                <li><a href="<?= $baseUrl ?>auth/login.php">Keluar / Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>