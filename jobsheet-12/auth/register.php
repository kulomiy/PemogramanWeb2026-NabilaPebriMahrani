<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/csrf.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, langsung diarahkan ke Dashboard
if (isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CamRent | Registrasi Petugas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main class="login-container" style="max-width: 480px; margin: 3rem auto; padding: 0 1rem;">
        
        <!-- Tombol Kembali ke Dashboard -->
        <div style="margin-bottom: 1.5rem; text-align: left;">
            <a href="../index.php" style="color: #A1777E; font-weight: 600; font-size: 0.95rem; transition: color 0.2s;">&larr; Kembali ke Dashboard</a>
        </div>
        
        <!-- Kotak Registrasi Card -->
        <section class="content-box" style="padding: 2.8rem 2.2rem; border-radius: 16px; border: 1px solid rgba(234, 220, 224, 0.8); box-shadow: 0 10px 30px rgba(89, 0, 10, 0.06);">
            <div style="text-align: center; margin-bottom: 2rem;">
                <span class="subtitle" style="color: #A1777E;">CAMRENT STUDIO</span>
                <h2 class="section-title" style="margin-bottom: 0.4rem; font-size: 1.8rem;">Daftar Petugas Baru ✨</h2>
                <p class="section-desc" style="margin-bottom: 0; font-size: 0.9rem;">Buat akun untuk mengelola inventaris kamera dan pelanggan.</p>
            </div>

            <!-- Flash Message Notifikasi -->
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="flash-message <?= e($_SESSION['flash']['type']) ?>" style="margin-bottom: 1.5rem;">
                    <?= e($_SESSION['flash']['message']) ?>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form action="proses_register.php" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap Petugas</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Misal: Nabila Pebri Mahrani" required autofocus>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username baru (tanpa spasi)" required autocomplete="username">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required minlength="6" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="konfirmasi_password">Konfirmasi Password</label>
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password di atas" required minlength="6" autocomplete="new-password">
                </div>
                
                <button type="submit" style="width: 100%; margin-top: 1rem; padding: 0.85rem; font-size: 1rem; border-radius: 8px;">Daftarkan Akun Petugas</button>
            </form>

            <!-- Link Kembali ke Login -->
            <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #EADCE0;">
                <p style="font-size: 0.9rem; color: #4b3e3e;">
                    Sudah punya akun petugas?<br>
                    <a href="login.php" style="color: #59000A; font-weight: 700; display: inline-block; margin-top: 0.4rem; text-decoration: underline;">
                        &larr; Masuk / Login di Sini
                    </a>
                </p>
            </div>
        </section>
    </main>

    <footer style="margin-top: 2rem; text-align: center; color: #A1777E; font-size: 0.85rem;">
        <p>&copy; 2026 CamRent Studio — Sistem Rental Kamera</p>
    </footer>

    <script src="../assets/js/main.js"></script>
</body>
</html>
