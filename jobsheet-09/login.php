<?php
$base = '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CamRent | Login Admin</title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <main class="login-container" style="max-width: 450px; margin: 4rem auto;">
        
        <!-- Tombol Kembali -->
        <div style="margin-bottom: 1.5rem; text-align: left;">
            <a href="index.php" style="color: #A1777E; font-weight: 600; font-size: 0.95rem; transition: color 0.2s;">&larr; Kembali ke Dashboard</a>
        </div>
        
        <!-- Kotak Login -->
        <section class="content-box" style="padding: 3rem 2.5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 class="section-title" style="margin-bottom: 0.5rem;">Selamat Datang di CamRent 👋</h2>
                <p class="section-desc" style="margin-bottom: 0;">Silakan masuk ke akun Anda.</p>
            </div>

            <form action="index.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username admin" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required />
                </div>
                
                <!-- Tombol Login (Lebarnya dibuat 100%) -->
                <button type="submit" style="width: 100%; margin-top: 1rem;">Login</button>
            </form>

            <!-- Opsi Buat Akun Baru -->
            <div style="text-align: center; margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid #EADCE0;">
                <p style="font-size: 0.95rem; color: #4b3e3e;">Belum punya akun? <br>
                <a href="#" style="color: #59000A; font-weight: 700; display: inline-block; margin-top: 0.5rem; text-decoration: underline;">Buat Akun Baru</a></p>
            </div>
        </section>
    </main>

    <footer style="margin-top: 2rem;">
        <p>&copy; 2026 CamRent — Sistem Rental Kamera</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>