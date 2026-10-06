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
    <title>CamRent | Login Petugas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main class="login-container" style="max-width: 460px; margin: 3.5rem auto; padding: 0 1rem;">
        
        <!-- Tombol Kembali ke Dashboard -->
        <div style="margin-bottom: 1.5rem; text-align: left;">
            <a href="../index.php" style="color: #A1777E; font-weight: 600; font-size: 0.95rem; transition: color 0.2s;">&larr; Kembali ke Dashboard</a>
        </div>
        
        <!-- Kotak Login Card -->
        <section class="content-box" style="padding: 2.8rem 2.2rem; border-radius: 16px; border: 1px solid rgba(234, 220, 224, 0.8); box-shadow: 0 10px 30px rgba(89, 0, 10, 0.06);">
            <div style="text-align: center; margin-bottom: 2rem;">
                <span class="subtitle" style="color: #A1777E;">CAMRENT STUDIO</span>
                <h2 class="section-title" style="margin-bottom: 0.4rem; font-size: 1.8rem;">Login Petugas 👋</h2>
                <p class="section-desc" style="margin-bottom: 0; font-size: 0.9rem;">Silakan masuk untuk mengelola data rental & pelanggan.</p>
            </div>

            <!-- Flash Message Notifikasi -->
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="flash-message <?= e($_SESSION['flash']['type']) ?>" style="margin-bottom: 1.5rem;">
                    <?= e($_SESSION['flash']['message']) ?>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <form action="proses_login.php" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username petugas" required autofocus autocomplete="username">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                </div>
                
                <button type="submit" style="width: 100%; margin-top: 1rem; padding: 0.85rem; font-size: 1rem; border-radius: 8px;">Masuk ke Sistem</button>
            </form>

            <!-- Link Registrasi Petugas -->
            <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #EADCE0;">
                <p style="font-size: 0.9rem; color: #4b3e3e;">
                    Belum punya akun petugas?<br>
                    <a href="register.php" style="color: #59000A; font-weight: 700; display: inline-block; margin-top: 0.4rem; text-decoration: underline;">
                        Daftar Petugas Baru di Sini &rarr;
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
