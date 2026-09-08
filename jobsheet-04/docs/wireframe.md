# Wireframe SIMPUS-Mini

## 1. Login

```text
┌─────────────────────────┐
│       SIMPUS-Mini       │
│                         │
│ Username                │
│ [____________________]  │
│                         │
│ Password                │
│ [____________________]  │
│                         │
│        [ LOGIN ]        │
└─────────────────────────┘
```

**Alur:**

```text
Login → Masukkan Username & Password → Dashboard
```

---

## 2. Dashboard Petugas

```text
┌──────────────────────────────────┐
│ SIMPUS-Mini          [ Logout ]  │
├──────────────────────────────────┤
│          Dashboard               │
│                                  │
│ ┌────────┐ ┌────────┐ ┌────────┐ │
│ │ Buku   │ │Anggota │ │Dipinjam│ │
│ │   20   │ │   15   │ │   5    │ │
│ └────────┘ └────────┘ └────────┘ │
│                                  │
│ [Peminjaman] [Pengembalian]      │
│ [Riwayat]                        │
└──────────────────────────────────┘
```

**Alur:**

```text
Dashboard → Pilih menu → Peminjaman / Pengembalian / Riwayat
```

---

## 3. Peminjaman

```text
┌──────────────────────────────────┐
│          Peminjaman Buku         │
│                                  │
│ Anggota                          │
│ [________________________]       │
│                                  │
│ Buku                             │
│ [________________________]       │
│                                  │
│ Tanggal                          │
│ [________________________]       │
│                                  │
│      [ Simpan Peminjaman ]       │
└──────────────────────────────────┘
```

**Alur:**

```text
Peminjaman → Pilih Anggota → Pilih Buku → Simpan
```

---

## 4. Pengembalian

```text
┌──────────────────────────────────┐
│        Pengembalian Buku         │
│                                  │
│ No. Anggota                      │
│ [________________________]       │
│                                  │
│ Data Peminjaman                  │
│ Buku: Laskar Pelangi             │
│ Tanggal: 01-09-2026              │
│                                  │
│    [ Proses Pengembalian ]       │
└──────────────────────────────────┘
```

**Alur:**

```text
Pengembalian → Cari Peminjaman → Pilih Data → Proses Pengembalian
```

---

## 5. Riwayat

```text
┌────────────────────────────────────────┐
│             Riwayat Transaksi          │
│                                        │
│ Cari: [____________________]           │
│                                        │
│ ┌────┬─────────┬────────────┬────────┐ │
│ │ No │ Anggota │ Buku       │ Status │ │
│ ├────┼─────────┼────────────┼────────┤ │
│ │ 1  │ A001    │ Laskar     │ Kembali│ │
│ │ 2  │ A002    │ Bumi       │ Dipinjam│ │
│ └────┴─────────┴────────────┴────────┘ │
└────────────────────────────────────────┘
```

**Alur:**

```text
Riwayat → Lihat Transaksi → Cari / Filter → Lihat Status
```

---

## 6. User Flow Keseluruhan

```text
             ┌─────────┐
             │  Login  │
             └────┬────┘
                  ↓
          ┌───────────────┐
          │   Dashboard   │
          └───────┬───────┘
                  ↓
       ┌──────────┼──────────┐
       ↓          ↓          ↓
 Peminjaman  Pengembalian  Riwayat
       │          │          │
       └──────────┼──────────┘
                  ↓
              Selesai
```

## 7. Kesimpulan

Wireframe SIMPUS-Mini dibuat sebagai rancangan awal sebelum proses implementasi. Wireframe mencakup halaman Login, Dashboard Petugas, Peminjaman, Pengembalian, dan Riwayat.

# 8. Latihan Tambahan Opsional

## 8.1 Wireframe Registrasi Anggota Baru

Halaman ini digunakan oleh tamu untuk mendaftarkan diri sebagai anggota perpustakaan.

```text
┌──────────────────────────────┐
│    Registrasi Anggota Baru   │
│                              │
│ Nama                         │
│ [________________________]   │
│                              │
│ Alamat                       │
│ [________________________]   │
│                              │
│ No. HP                       │
│ [________________________]   │
│                              │
│      [ Daftar ]              │
└──────────────────────────────┘
```

**Alur:**

```text
Registrasi
    ↓
Isi Data Anggota
    ↓
Klik Daftar
    ↓
Data Anggota Tersimpan
```

---

## 8.2 User Flow Mencari Anggota yang Terlambat

Skenario ini digunakan petugas untuk mencari anggota yang memiliki keterlambatan dalam pengembalian buku.

```text
Dashboard
    ↓
Riwayat
    ↓
Cari Anggota
    ↓
Periksa Data Peminjaman
    ↓
Cek Tanggal Jatuh Tempo
    ↓
Anggota Terlambat
```

Jika anggota tidak memiliki keterlambatan:

```text
Cari Anggota
    ↓
Periksa Data Peminjaman
    ↓
Tidak Ada Keterlambatan
```

---

## 8.3 Edge Case Peminjaman Buku yang Sama

Edge case ini terjadi ketika petugas mencoba meminjamkan buku yang sama kepada anggota yang sama, padahal buku tersebut masih dalam status dipinjam.

```text
Petugas
    ↓
Pilih Anggota
    ↓
Pilih Buku
    ↓
Cek Status Peminjaman
    ↓
Buku Masih Dipinjam?
    │
    ├── Ya → Tampilkan Pesan
    │         "Buku masih dipinjam oleh anggota."
    │
    └── Tidak → Peminjaman Berhasil
```

**Penanganan:**

Jika buku masih dalam status dipinjam oleh anggota yang sama, sistem tidak membuat transaksi peminjaman baru dan menampilkan pesan kepada petugas.

Contoh:

```text
┌────────────────────────────────────┐
│        Peminjaman Tidak Berhasil   │
│                                    │
│ Buku masih sedang dipinjam oleh   │
│ anggota tersebut.                 │
│                                    │
│            [ OK ]                  │
└────────────────────────────────────┘
```
