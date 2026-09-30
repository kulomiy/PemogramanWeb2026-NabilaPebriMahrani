<?php
// ====================================================================
// CamRent Studio - Konfigurasi Koneksi Database (PDO MySQL)
// Kompatibel dengan: InfinityFree Hosting & Localhost (XAMPP / Laragon)
// ====================================================================
//
// 📌 PETUNJUK KONEKSI UNTUK HOSTING DI INFINITYFREE:
// 1. Masuk ke Control Panel (vPanel) InfinityFree Anda.
// 2. Buka menu "MySQL Databases".
// 3. Buat database baru (misal diberi nama "camrent").
//    InfinityFree akan menambahkan prefix, sehingga namanya menjadi:
//    Contoh: if0_38000000_camrent
// 4. Salin data dari halaman MySQL Databases tersebut dan ubah variabel di bawah:
//    - $host = 'sqlXXX.infinityfree.com';  <-- MySQL Hostname dari vPanel
//    - $user = 'if0_38000000';             <-- MySQL Username dari vPanel
//    - $pass = 'PASSWORD_VPANEL_ANDA';     <-- Password vPanel akun Anda
//    - $db   = 'if0_38000000_camrent';     <-- Nama Database Lengkap
//
// --------------------------------------------------------------------

// Konfigurasi Database (Bisa disesuaikan langsung atau lewat Environment Variables)
$host = getenv('DB_HOST') ?: '127.0.0.1'; // Ganti dengan MySQL Hostname InfinityFree saat upload
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'camrent';   // Ganti dengan Nama Database Lengkap InfinityFree saat upload
$user = getenv('DB_USER') ?: 'root';      // Ganti dengan MySQL Username InfinityFree saat upload
$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : ''; // Ganti dengan vPanel password Anda saat upload

// DSN (Data Source Name) menggunakan driver MySQL
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    // Inisialisasi koneksi PDO MySQL
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Menampilkan error sebagai Exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Hasil fetch otomatis array asosiatif
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Native prepared statements
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"     // Memastikan charset utf8mb4
    ]);
} catch (PDOException $e) {
    // Tampilan penanganan error yang rapi dan informatif
    $pesanError = htmlspecialchars($e->getMessage());
    die("
    <div style='font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif; max-width: 650px; margin: 3rem auto; padding: 2rem; background: #FFF5F5; border: 1px solid #FED7D7; border-radius: 12px; color: #742A2A; box-shadow: 0 4px 15px rgba(0,0,0,0.05);'>
        <h3 style='margin-top: 0; color: #9B2C2C; font-size: 1.3rem;'>⚠️ Koneksi ke Database Gagal</h3>
        <p style='line-height: 1.6;'>Sistem tidak dapat terhubung ke database MySQL. Jika Anda sedang meng-hosting di <strong>InfinityFree</strong>, pastikan data pada file <code>includes/koneksi.php</code> sudah sesuai dengan informasi di menu <em>MySQL Databases</em> pada vPanel Anda:</p>
        <ul style='line-height: 1.8; margin-bottom: 1.5rem;'>
            <li><strong>Host:</strong> sqlXXX.infinityfree.com (bukan localhost)</li>
            <li><strong>Username:</strong> if0_xxxxxx</li>
            <li><strong>Password:</strong> Password vPanel akun InfinityFree</li>
            <li><strong>Database:</strong> if0_xxxxxx_camrent</li>
        </ul>
        <div style='background: #FFFFFF; padding: 0.8rem 1rem; border-radius: 6px; border: 1px solid #E2E8F0; font-family: monospace; font-size: 0.85rem; color: #C53030;'>
            <strong>Pesan Error:</strong> {$pesanError}
        </div>
    </div>
    ");
}
