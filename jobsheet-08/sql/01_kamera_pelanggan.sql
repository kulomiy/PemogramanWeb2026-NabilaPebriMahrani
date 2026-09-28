-- 1. Buat Tabel 'kamera'
-- Catatan Perubahan Jobsheet 8: 
-- Menggunakan SERIAL sebagai Primary Key agar ID bernilai unik dan auto-increment.
DROP TABLE IF EXISTS kamera CASCADE;

CREATE TABLE kamera (
    id SERIAL PRIMARY KEY,
    nama_alat VARCHAR(150) NOT NULL,
    merek VARCHAR(100) NOT NULL,
    tahun_beli INT NOT NULL,
    sn VARCHAR(100),
    stok INT NOT NULL DEFAULT 0,
    kategori VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data Dummy Awal untuk Tabel 'kamera' (Data dari Jobsheet 7)
INSERT INTO kamera (nama_alat, merek, tahun_beli, sn, stok, kategori) VALUES
('Alpha A7 Mark III', 'Sony', 2021, 'SN-SNY-001', 4, 'mirrorless'),
('EOS R6 Mark II', 'Canon', 2023, 'SN-CAN-002', 2, 'mirrorless'),
('Fujifilm X-T4', 'Fujifilm', 2022, 'SN-FUJ-003', 3, 'mirrorless'),
('Lensa FE 24-70mm f/2.8', 'Sony', 2020, 'SN-LNS-004', 0, 'lensa'),
('DJI Ronin-SC', 'DJI', 2022, 'SN-DJI-005', 5, 'aksesoris');


-- 2. Buat Tabel 'pelanggan'
-- Catatan Perubahan Jobsheet 8:
-- Kolom 'id' menggunakan SERIAL PRIMARY KEY untuk identifikasi baris tabel secara internal.
-- Kolom 'id_reg' menggunakan UNIQUE untuk menjaga keunikan kode registrasi pelanggan.
DROP TABLE IF EXISTS pelanggan CASCADE;

CREATE TABLE pelanggan (
    id SERIAL PRIMARY KEY,
    id_reg VARCHAR(50) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(150) NOT NULL,
    no_ktp VARCHAR(50) NOT NULL,
    no_hp VARCHAR(30) NOT NULL,
    alamat TEXT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Proses Cek',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data Dummy Awal untuk Tabel 'pelanggan' (Data dari Jobsheet 7)
INSERT INTO pelanggan (id_reg, nama_lengkap, no_ktp, no_hp, alamat, status) VALUES
('P-001', 'Ahmad Fauzi', '357301234567', '08123456789', 'Jl. Semanggi No. 12, Malang', 'Terverifikasi'),
('P-002', 'Siti Nurhaliza', '357309876543', '08198765432', 'Jl. Bunga Melati No. 4, Surabaya', 'Proses Cek'),
('P-003', 'Budi Santoso', '357311223344', '08571234567', 'Jl. Cengger Ayam No. 8, Malang', 'Terverifikasi'),
('P-004', 'Dewi Lestari', '357322334455', '08219876543', 'Jl. Soekarno Hatta No. 25, Malang', 'Terverifikasi');
