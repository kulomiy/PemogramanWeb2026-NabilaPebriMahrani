-- ========================================================
-- CamRent Studio - Skrip Database Tabel Users (Petugas)
-- Kompatibel dengan: MySQL / MariaDB / phpMyAdmin / InfinityFree
-- ========================================================

-- 1. Buat Tabel 'users'
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nama_lengkap` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data Awal Petugas / Administrator
-- Password bawaan:
-- 1. Username: admin      | Password: admin123
-- 2. Username: petugas    | Password: petugas123
-- Keduanya telah di-hash menggunakan password_hash() standar PHP BCRYPT
INSERT INTO `users` (`username`, `password`, `nama_lengkap`) VALUES
('admin', '$2y$10$h1YUWLmv.I6hZeSSgiazueAC.nc/3YQmy6FPBlF.TTnslYgImoydG', 'Administrator CamRent'),
('petugas', '$2y$10$PKXLN1EYWdYn0JB4UDq06eJj765HbMQ9FYo06u4MQqLXyK2MKwPGC', 'Petugas Rental');
