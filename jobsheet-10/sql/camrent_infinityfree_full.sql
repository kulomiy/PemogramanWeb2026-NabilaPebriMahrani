-- ====================================================================
-- CamRent Studio - Skrip Database Lengkap (All-in-One Import)
-- Siap import langsung ke phpMyAdmin di InfinityFree / XAMPP
-- Catatan InfinityFree:
-- Jangan buat query CREATE DATABASE di sini karena database dibuat via vPanel.
-- Cukup pilih database Anda di phpMyAdmin, lalu klik menu Import file ini.
-- ====================================================================

-- --------------------------------------------------------------------
-- 1. TABEL: kamera
-- --------------------------------------------------------------------
DROP TABLE IF EXISTS `kamera`;

CREATE TABLE `kamera` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_alat` VARCHAR(150) NOT NULL,
    `merek` VARCHAR(100) NOT NULL,
    `tahun_beli` INT NOT NULL,
    `sn` VARCHAR(100) DEFAULT NULL,
    `stok` INT NOT NULL DEFAULT 0,
    `kategori` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `kamera` (`nama_alat`, `merek`, `tahun_beli`, `sn`, `stok`, `kategori`) VALUES
('Alpha A7 Mark III', 'Sony', 2021, 'SN-SNY-001', 4, 'mirrorless'),
('EOS R6 Mark II', 'Canon', 2023, 'SN-CAN-002', 2, 'mirrorless'),
('Fujifilm X-T4', 'Fujifilm', 2022, 'SN-FUJ-003', 3, 'mirrorless'),
('Lensa FE 24-70mm f/2.8', 'Sony', 2020, 'SN-LNS-004', 0, 'lensa'),
('DJI Ronin-SC', 'DJI', 2022, 'SN-DJI-005', 5, 'aksesoris');

-- --------------------------------------------------------------------
-- 2. TABEL: pelanggan
-- --------------------------------------------------------------------
DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_reg` VARCHAR(50) NOT NULL UNIQUE,
    `nama_lengkap` VARCHAR(150) NOT NULL,
    `no_ktp` VARCHAR(50) NOT NULL,
    `no_hp` VARCHAR(30) NOT NULL,
    `alamat` TEXT NOT NULL,
    `status` VARCHAR(50) NOT NULL DEFAULT 'Proses Cek',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pelanggan` (`id_reg`, `nama_lengkap`, `no_ktp`, `no_hp`, `alamat`, `status`) VALUES
('P-001', 'Ahmad Fauzi', '357301234567', '08123456789', 'Jl. Semanggi No. 12, Malang', 'Terverifikasi'),
('P-002', 'Siti Nurhaliza', '357309876543', '08198765432', 'Jl. Bunga Melati No. 4, Surabaya', 'Proses Cek'),
('P-003', 'Budi Santoso', '357311223344', '08571234567', 'Jl. Cengger Ayam No. 8, Malang', 'Terverifikasi'),
('P-004', 'Dewi Lestari', '357322334455', '08219876543', 'Jl. Soekarno Hatta No. 25, Malang', 'Terverifikasi');

-- --------------------------------------------------------------------
-- 3. TABEL: users (Petugas & Administrator)
-- --------------------------------------------------------------------
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nama_lengkap` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Akun Petugas Bawaan:
-- 1) Username: admin   | Password: admin123
-- 2) Username: petugas | Password: petugas123
INSERT INTO `users` (`username`, `password`, `nama_lengkap`) VALUES
('admin', '$2y$10$h1YUWLmv.I6hZeSSgiazueAC.nc/3YQmy6FPBlF.TTnslYgImoydG', 'Administrator CamRent'),
('petugas', '$2y$10$PKXLN1EYWdYn0JB4UDq06eJj765HbMQ9FYo06u4MQqLXyK2MKwPGC', 'Petugas Rental');
