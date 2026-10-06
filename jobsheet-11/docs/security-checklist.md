# Security Checklist — Jobsheet 11 CamRent Studio

## 1. XSS (Cross-Site Scripting)

**Before:** output data database/`$_GET` menggunakan `htmlspecialchars()` secara langsung dan belum memiliki helper terpusat.

**After:** seluruh output dinamis menggunakan helper `e()` dari `includes/helpers.php`. Helper menggunakan `htmlspecialchars()` dengan `ENT_QUOTES` dan UTF-8.

Contoh:
```php
<?= e($item['nama_alat']) ?>
```

## 2. CSRF (Cross-Site Request Forgery)

**Before:** form POST belum memiliki token CSRF.

**After:** `includes/csrf.php` menyediakan:
- `csrf_token()` untuk membuat/mengambil token session.
- `csrf_field()` untuk menambahkan hidden input pada form.
- `csrf_verify()` untuk memvalidasi token sebelum proses database.

Token diterapkan pada form Login, Register, Tambah, Edit, dan Hapus Kamera/Pelanggan.

## 3. Session Fixation

**Before:** login belum meregenerasi session ID setelah autentikasi.

**After:** `auth/proses_login.php` menggunakan:
```php
session_regenerate_id(true);
```
setelah username dan password berhasil diverifikasi.

## 4. SQL Injection

Audit menunjukkan query database sudah menggunakan prepared statement dan parameter binding. Tidak ada perubahan kode yang diperlukan untuk bagian ini.

## 5. Kesimpulan

Jobsheet 11 memperkuat keamanan aplikasi dengan output escaping terpusat, perlindungan CSRF pada request POST, session regeneration setelah login, dan audit prepared statement terhadap SQL Injection.
