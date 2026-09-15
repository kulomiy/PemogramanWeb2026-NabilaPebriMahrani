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
