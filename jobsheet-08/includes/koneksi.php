<?php
// Konfigurasi Database Lokal
$host = '127.0.0.1';
$port = '5432';
$db   = 'camrent';
$user = 'postgres';
$pass = '123';

// DSN (Data Source Name) khusus untuk driver 'pgsql'
$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    // Inisialisasi koneksi PDO
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Menampilkan error sebagai Exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Hasil fetch berupa array asosiatif
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Menggunakan prepared statement native PostgreSQL
    ]);
} catch (PDOException $e) {
    // Penanganan error koneksi database
    die("Koneksi ke database gagal: " . $e->getMessage());
}
