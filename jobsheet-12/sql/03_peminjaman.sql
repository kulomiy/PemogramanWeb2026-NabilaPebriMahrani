-- ========================================================
-- CamRent Studio - Jobsheet 12
-- Tabel transaksi peminjaman kamera oleh pelanggan
-- ========================================================

CREATE TABLE IF NOT EXISTS `peminjaman` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `pelanggan_id` INT NOT NULL,
    `kamera_id` INT NOT NULL,
    `tanggal_pinjam` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `tanggal_kembali` TIMESTAMP NULL DEFAULT NULL,
    `status` VARCHAR(30) NOT NULL DEFAULT 'dipinjam',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_peminjaman_pelanggan`
        FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT `fk_peminjaman_kamera`
        FOREIGN KEY (`kamera_id`) REFERENCES `kamera` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    INDEX `idx_peminjaman_status` (`status`),
    INDEX `idx_peminjaman_pelanggan` (`pelanggan_id`),
    INDEX `idx_peminjaman_kamera` (`kamera_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
