# 📐 CamRent Studio - System Wireframe & Layout Architecture

Dokumentasi ini berisi rancangan struktur tata letak (wireframe) halaman-halaman utama pada sistem manajemen rental kamera **CamRent Studio**.

---

## 1. Halaman Utama / Dashboard (`index.html`)
Menjadi pusat kendali utama dengan navigasi menu lengkap dan ringkasan statistik inventaris serta pelanggan.

+-----------------------------------------------------------------------------------+
|  SISTEM MANAJEMEN RENTAL                    [       ABOUT US ↗      ] (Header)    |
|  CamRent Studio                             [ Senin-Minggu: 09.00 - 22.00 WIB ]   |
+-----------------------------------------------------------------------------------+
|  [☰ Menu] | Dashboard | Data Kamera | Tambah Kamera | Data Pelanggan | Keluar |  |
+-----------------------------------------------------------------------------------+
|  MAIN CONTENT                                                                     |
|                                                                                   |
|  +-------------------------+  +-------------------------+  +-------------------+  |
|  |     Total Inventaris    |  |    Pelanggan Terdaftar  |  |    Sedang Disewa  |  |
|  |         24 Alat         |  |       156 Orang         |  |      8 Unit       |  |
|  +-------------------------+  +-------------------------+  +-------------------+  |
|                                                                                   |
|  [ Tabel Aktivitas / Ringkasan Peminjaman Terbaru ]                               |
+-----------------------------------------------------------------------------------+
|  © 2026 CamRent — Sistem Rental Kamera                                            |
+-----------------------------------------------------------------------------------+

+-----------------------------------------------------------------------------------+
|  SISTEM MANAJEMEN RENTAL                    [ ← Dashboard ] (Tombol Kapsul)       |
|  CamRent Studio                                                                   |
+-----------------------------------------------------------------------------------+
|  MAIN CONTENT                                                                     |
|                                                                                   |
|                                  EST. 2026                                        |
|                         Mengenal CamRent Studio ✦                                 |
|               Cerita, komitmen, dan ruang di balik setiap lensa.                  |
|                                                                                   |
|  -------------------------------------------------------------------------------  |
|                                                                                   |
|  Cerita Singkat & Visi Kami                                                       |
|  [ Paragraf narasi mengenai latar belakang berdirinya CamRent Studio di Malang ]  |
|                                                                                   |
|  Informasi Operasional & Lokasi                                                   |
|  +-------------------------------+  +------------------------------------------+  |
|  | Jam Operasional               |  | Lokasi Studio                            |  |
|  | Senin – Minggu                |  | Jl. Soekarno Hatta No. 45, Malang        |  |
|  | 09.00 – 22.00 WIB             |  | [ Buka di Google Maps ↗ ]                |  |
|  +-------------------------------+  +------------------------------------------+  |
|                                                                                   |
|  Ulasan Pelanggan                                                                 |
|  +-------------------------------+  +------------------------------------------+  |
|  | "Pelayanan sangat ramah..."   |  | "Proses sewanya cepat..."                |  |
|  | — Kak Rian (Google Maps)      |  | — Sarah A. (Pelanggan Setia)             |  |
|  +-------------------------------+  +------------------------------------------+  |
+-----------------------------------------------------------------------------------+
|  © 2026 CamRent — Sistem Rental Kamera                                            |
+-----------------------------------------------------------------------------------+

+-----------------------------------------------------------------------------------+
|  SISTEM MANAJEMEN RENTAL                    [       ABOUT US ↗      ]             |
|  CamRent Studio                                                                   |
+-----------------------------------------------------------------------------------+
|  [☰ Menu] | Dashboard | Data Kamera (*) | Tambah Kamera | Data Pelanggan | ...    |
+-----------------------------------------------------------------------------------+
|  MAIN CONTENT                                                                     |
|                                                                                   |
|  Daftar Alat & Kamera                     [ + Tambah Alat ]                       |
|  +-----------------------------------------------------------------------------+  |
|  | NAMA ALAT             | MEREK    | TAHUN BELI | STOK | AKSI                 |  |
|  +-----------------------+----------+------------+------+----------------------+  |
|  | Alpha A7 Mark III     | Sony     | 2021       | 4    | [Edit] [Hapus]       |  |
|  | EOS R6 Mark II        | Canon    | 2023       | 2    | [Edit] [Hapus]       |  |
|  | Fujifilm X-T4         | Fujifilm | 2022       | 3    | [Edit] [Hapus]       |  |
|  +-----------------------------------------------------------------------------+  |
|                  Menampilkan 5 dari 24 Total Inventaris                           |
+-----------------------------------------------------------------------------------+
|  © 2026 CamRent — Sistem Rental Kamera                                            |
+-----------------------------------------------------------------------------------+

+-----------------------------------------------------------------------------------+
|  SISTEM MANAJEMEN RENTAL                    [       ABOUT US ↗      ]             |
|  CamRent Studio                                                                   |
+-----------------------------------------------------------------------------------+
|  [☰ Menu] | Dashboard | Data Kamera | Tambah Kamera (*) | Data Pelanggan | ...    |
+-----------------------------------------------------------------------------------+
|  MAIN CONTENT                                                                     |
|                                                                                   |
|  Tambah Data Alat                                                                 |
|  -------------------------------------------------------------------------------  |
|  Nama Alat / Lensa     [ Masukkan nama alat...                         ]          |
|  Merek                 [ Masukkan merek...                             ]          |
|  Tahun Pembelian       [ Pilih tahun...                                ]          |
|  Nomor Seri (SN)       [ Masukkan nomor seri unit...                   ]          |
|  Jumlah Stok           [ 0                                             ]          |
|  Kategori Alat         [ Kamera Mirrorless v                           ]          |
|                                                                                   |
|  [ Simpan Data ]                                                                  |
+-----------------------------------------------------------------------------------+
|  © 2026 CamRent — Sistem Rental Kamera                                            |
+-----------------------------------------------------------------------------------+

+-----------------------------------------------------------------------------------+
|  SISTEM MANAJEMEN RENTAL                    [       ABOUT US ↗      ]             |
|  CamRent Studio                                                                   |
+-----------------------------------------------------------------------------------+
|  [☰ Menu] | Dashboard | Data Kamera | Tambah Kamera | Data Pelanggan (*) | ...    |
+-----------------------------------------------------------------------------------+
|  MAIN CONTENT                                                                     |
|                                                                                   |
|  Daftar Pelanggan                         [ + Registrasi Pelanggan ]              |
|  +-----------------------------------------------------------------------------+  |
|  | ID REG | NAMA LENGKAP     | NO. KTP      | NO. HP (WA)  | STATUS     | AKSI |  |
|  +--------+------------------+--------------+--------------+------------+--------+|
|  | P-001  | Ahmad Fauzi      | 35730123...  | 081234...    | [Verif]    | [E][H]| |
|  | P-002  | Siti Nurhaliza   | 35730987...  | 081987...    | [Proses]   | [E][H]| |
|  +-----------------------------------------------------------------------------+  |
|                  Menampilkan 4 dari 156 Total Pelanggan                           |
+-----------------------------------------------------------------------------------+
|  © 2026 CamRent — Sistem Rental Kamera                                            |
+-----------------------------------------------------------------------------------+

+-----------------------------------------------------------------------------------+
|  SISTEM MANAJEMEN RENTAL                    [       ABOUT US ↗      ]             |
|  CamRent Studio                                                                   |
+-----------------------------------------------------------------------------------+
|  [☰ Menu] | Dashboard | Data Kamera | Tambah Kamera | Tambah Pelanggan (*)        |
+-----------------------------------------------------------------------------------+
|  MAIN CONTENT                                                                     |
|                                                                                   |
|  Registrasi Pelanggan Baru                                                        |
|  -------------------------------------------------------------------------------  |
|  ID Registrasi         [ P-003 (Readonly)                              ]          |
|  Nama Lengkap KTP      [ Masukkan nama sesuai KTP...                   ]          |
|  Nomor Identitas       [ Masukkan nomor KTP / SIM...                   ]          |
|  Nomor HP (WhatsApp)   [ Contoh: 0812...                               ]          |
|  Alamat Domisili       [ Masukkan alamat lengkap...                    ]          |
|                                                                                   |
|  [ Simpan Data Pelanggan ]                                                        |
+-----------------------------------------------------------------------------------+
|  © 2026 CamRent — Sistem Rental Kamera                                            |
+-----------------------------------------------------------------------------------+