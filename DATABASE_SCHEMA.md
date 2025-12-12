# Skema Database Sistem Pemesanan Tiket Wisata

## Daftar Isi
- [Overview](#overview)
- [Tabel Database](#tabel-database)
- [Relasi Antar Tabel](#relasi-antar-tabel)
- [Diagram ERD](#diagram-erd)
- [Alur Bisnis](#alur-bisnis)

---

## Overview

Database ini dirancang untuk sistem pemesanan tiket wisata online dengan fitur:
- Multi-role user management (Admin, Petugas, Bendahara, Owner)
- Pemesanan tiket dengan validasi pembayaran
- Generate tiket dengan QR code
- Verifikasi keuangan oleh bendahara
- Scan tiket oleh petugas
- Galeri foto wisata

---

## Tabel Database

### 1. Tabel `users`
Menyimpan data pengguna sistem dengan berbagai role.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | BIGINT (PK) | Primary key |
| `name` | VARCHAR | Nama pengguna |
| `email` | VARCHAR (UNIQUE) | Email pengguna |
| `password` | VARCHAR | Password (hashed) |
| `role` | ENUM | 'Admin', 'Petugas', 'Bendahara', 'Owner' (default: 'Petugas') |
| `nomor_telepon` | VARCHAR (NULLABLE) | Nomor telepon |
| `aktif` | BOOLEAN | Status aktif (default: true) |
| `remember_token` | VARCHAR (NULLABLE) | Token remember me |
| `email_verified_at` | TIMESTAMP (NULLABLE) | Waktu verifikasi email |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Fungsi Role:**
- **Admin**: Validasi pembayaran, kelola wisata, kelola user
- **Petugas**: Scan tiket pengunjung
- **Bendahara**: Verifikasi transaksi keuangan
- **Owner**: Monitoring dan laporan

---

### 2. Tabel `wisata`
Menyimpan informasi tempat wisata dan konfigurasi harga.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | BIGINT (PK) | Primary key |
| `deskripsi` | TEXT (NULLABLE) | Deskripsi tempat wisata |
| `harga_tiket` | DECIMAL(10,2) | Harga tiket masuk (default: 0) |
| `biaya_parkir_motor` | DECIMAL(10,2) | Biaya parkir motor (default: 0) |
| `biaya_parkir_mobil` | DECIMAL(10,2) | Biaya parkir mobil (default: 0) |
| `nomor_rekening` | VARCHAR (NULLABLE) | Nomor rekening pembayaran |
| `nama_bank` | VARCHAR (NULLABLE) | Nama bank |
| `atas_nama` | VARCHAR (NULLABLE) | Nama pemilik rekening |
| `email_kontak` | VARCHAR (NULLABLE) | Email kontak wisata |
| `nomor_whatsapp` | VARCHAR (NULLABLE) | Nomor WhatsApp kontak |
| `aktif` | BOOLEAN | Status aktif (default: true) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Catatan:** Biasanya hanya ada 1 record dalam tabel ini untuk konfigurasi wisata.

---

### 3. Tabel `galeri_wisata`
Menyimpan foto-foto galeri tempat wisata.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | BIGINT (PK) | Primary key |
| `wisata_id` | BIGINT (FK) | Foreign key ke tabel wisata |
| `nama_file` | VARCHAR | Nama file gambar |
| `path_file` | VARCHAR | Path/lokasi file gambar |
| `keterangan` | VARCHAR (NULLABLE) | Keterangan/caption gambar |
| `utama` | BOOLEAN | Penanda foto utama (default: false) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Relasi:**
- `wisata_id` → `wisata.id` (ON DELETE CASCADE)

---

### 4. Tabel `pemesanan`
Menyimpan data pemesanan tiket dari pengunjung.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | BIGINT (PK) | Primary key |
| `kode_pemesanan` | VARCHAR (UNIQUE) | Kode unik pemesanan |
| `nama_pemesan` | VARCHAR | Nama pemesan |
| `email_pemesan` | VARCHAR | Email pemesan |
| `nomor_whatsapp` | VARCHAR | Nomor WhatsApp pemesan |
| `tanggal_kunjungan` | DATE | Tanggal rencana kunjungan |
| `jumlah_tiket` | INTEGER | Jumlah tiket yang dipesan (default: 0) |
| `jumlah_parkir_motor` | INTEGER | Jumlah parkir motor (default: 0) |
| `jumlah_parkir_mobil` | INTEGER | Jumlah parkir mobil (default: 0) |
| `total_harga` | DECIMAL(12,2) | Total harga pemesanan |
| `bukti_transfer` | VARCHAR (NULLABLE) | Path file bukti transfer |
| `status_pembayaran` | ENUM | 'menunggu', 'valid', 'tidak_valid' (default: 'menunggu') |
| `catatan_admin` | TEXT (NULLABLE) | Catatan dari admin |
| `divalidasi_oleh` | BIGINT (FK, NULLABLE) | Foreign key ke users (admin validator) |
| `tanggal_validasi` | TIMESTAMP (NULLABLE) | Waktu validasi pembayaran |
| `diverifikasi_bendahara` | BOOLEAN | Status verifikasi bendahara (default: false) |
| `diverifikasi_oleh_bendahara` | BIGINT (FK, NULLABLE) | Foreign key ke users (bendahara) |
| `tanggal_verifikasi_bendahara` | TIMESTAMP (NULLABLE) | Waktu verifikasi bendahara |
| `catatan_bendahara` | TEXT (NULLABLE) | Catatan dari bendahara |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Relasi:**
- `divalidasi_oleh` → `users.id` (ON DELETE SET NULL)
- `diverifikasi_oleh_bendahara` → `users.id` (ON DELETE SET NULL)

**Status Pembayaran:**
- `menunggu`: Menunggu validasi admin
- `valid`: Pembayaran valid, tiket digenerate
- `tidak_valid`: Pembayaran ditolak

---

### 5. Tabel `tiket`
Menyimpan data tiket individual yang dihasilkan dari pemesanan.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| `id` | BIGINT (PK) | Primary key |
| `pemesanan_id` | BIGINT (FK) | Foreign key ke tabel pemesanan |
| `kode_tiket` | VARCHAR (UNIQUE) | Kode unik tiket |
| `qr_code_path` | VARCHAR (NULLABLE) | Path file QR code |
| `jenis_tiket` | VARCHAR | Jenis tiket (default: 'umum') |
| `sudah_digunakan` | BOOLEAN | Status penggunaan tiket (default: false) |
| `tanggal_scan` | TIMESTAMP (NULLABLE) | Waktu tiket discan |
| `discan_oleh` | BIGINT (FK, NULLABLE) | Foreign key ke users (petugas) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

**Relasi:**
- `pemesanan_id` → `pemesanan.id` (ON DELETE CASCADE)
- `discan_oleh` → `users.id` (ON DELETE SET NULL)

**Catatan:** Jumlah record tiket = `pemesanan.jumlah_tiket`

---

## Relasi Antar Tabel

### One-to-Many Relationships

1. **users → pemesanan (validator)**
   - Satu admin dapat memvalidasi banyak pemesanan
   - Foreign Key: `pemesanan.divalidasi_oleh` → `users.id`
   - ON DELETE: SET NULL

2. **users → pemesanan (verifikator bendahara)**
   - Satu bendahara dapat memverifikasi banyak pemesanan
   - Foreign Key: `pemesanan.diverifikasi_oleh_bendahara` → `users.id`
   - ON DELETE: SET NULL

3. **users → tiket (petugas scanner)**
   - Satu petugas dapat menscan banyak tiket
   - Foreign Key: `tiket.discan_oleh` → `users.id`
   - ON DELETE: SET NULL

4. **wisata → galeri_wisata**
   - Satu wisata memiliki banyak foto galeri
   - Foreign Key: `galeri_wisata.wisata_id` → `wisata.id`
   - ON DELETE: CASCADE

5. **pemesanan → tiket**
   - Satu pemesanan menghasilkan banyak tiket
   - Foreign Key: `tiket.pemesanan_id` → `pemesanan.id`
   - ON DELETE: CASCADE

---

## Diagram ERD

```
┌─────────────────┐
│     users       │
│─────────────────│
│ id (PK)         │
│ name            │
│ email           │
│ password        │
│ role            │
│ nomor_telepon   │
│ aktif           │
└─────────────────┘
        │
        │ 1:N (divalidasi_oleh)
        ├──────────────────────────┐
        │                          │
        │ 1:N (diverifikasi_oleh)  │
        ├──────────────────┐       │
        │                  │       │
        │ 1:N (discan)     │       │
        │                  ▼       ▼
        │         ┌─────────────────────────┐
        │         │     pemesanan           │
        │         │─────────────────────────│
        │         │ id (PK)                 │
        │         │ kode_pemesanan          │
        │         │ nama_pemesan            │
        │         │ email_pemesan           │
        │         │ nomor_whatsapp          │
        │         │ tanggal_kunjungan       │
        │         │ jumlah_tiket            │
        │         │ jumlah_parkir_motor     │
        │         │ jumlah_parkir_mobil     │
        │         │ total_harga             │
        │         │ bukti_transfer          │
        │         │ status_pembayaran       │
        │         │ catatan_admin           │
        │         │ divalidasi_oleh (FK)    │
        │         │ tanggal_validasi        │
        │         │ diverifikasi_bendahara  │
        │         │ diverifikasi_oleh_bend. │
        │         │ tanggal_verifikasi_bend.│
        │         │ catatan_bendahara       │
        │         └─────────────────────────┘
        │                  │
        │                  │ 1:N
        │                  ▼
        │         ┌─────────────────┐
        └────────>│     tiket       │
                  │─────────────────│
                  │ id (PK)         │
                  │ pemesanan_id(FK)│
                  │ kode_tiket      │
                  │ qr_code_path    │
                  │ jenis_tiket     │
                  │ sudah_digunakan │
                  │ tanggal_scan    │
                  │ discan_oleh (FK)│
                  └─────────────────┘


┌─────────────────┐
│     wisata      │
│─────────────────│
│ id (PK)         │
│ deskripsi       │
│ harga_tiket     │
│ biaya_parkir_m. │
│ biaya_parkir_mb.│
│ nomor_rekening  │
│ nama_bank       │
│ atas_nama       │
│ email_kontak    │
│ nomor_whatsapp  │
│ aktif           │
└─────────────────┘
        │
        │ 1:N
        ▼
┌─────────────────┐
│ galeri_wisata   │
│─────────────────│
│ id (PK)         │
│ wisata_id (FK)  │
│ nama_file       │
│ path_file       │
│ keterangan      │
│ utama           │
└─────────────────┘
```

---

## Alur Bisnis

### 1. Proses Pemesanan Tiket

```
┌─────────────┐
│ Pengunjung  │
│ mengisi form│
│ pemesanan   │
└──────┬──────┘
       │
       ▼
┌─────────────────────────────┐
│ Data masuk ke tabel         │
│ pemesanan                   │
│ status: 'menunggu'          │
└──────┬──────────────────────┘
       │
       ▼
┌─────────────────────────────┐
│ Pengunjung upload           │
│ bukti_transfer              │
└──────┬──────────────────────┘
       │
       ▼
┌─────────────────────────────┐
│ Admin validasi pembayaran   │
│ - Update status_pembayaran  │
│ - Set divalidasi_oleh       │
│ - Set tanggal_validasi      │
└──────┬──────────────────────┘
       │
       ├─── valid ────┐
       │              │
       │              ▼
       │     ┌─────────────────────┐
       │     │ Generate tiket      │
       │     │ - Buat N tiket      │
       │     │ - Generate QR code  │
       │     │ - Kirim email       │
       │     └─────────┬───────────┘
       │               │
       │               ▼
       │     ┌─────────────────────┐
       │     │ Bendahara verifikasi│
       │     │ - Set diverifikasi  │
       │     │ - Set verifikator   │
       │     │ - Set tanggal       │
       │     └─────────┬───────────┘
       │               │
       │               ▼
       │     ┌─────────────────────┐
       │     │ Pengunjung datang   │
       │     │ dengan tiket        │
       │     └─────────┬───────────┘
       │               │
       │               ▼
       │     ┌─────────────────────┐
       │     │ Petugas scan QR     │
       │     │ - Set sudah_digunakan│
       │     │ - Set tanggal_scan  │
       │     │ - Set discan_oleh   │
       │     └─────────────────────┘
       │
       └─── tidak_valid ───> [Selesai - Ditolak]
```

### 2. Role dan Tanggung Jawab

| Role | Akses | Fungsi Utama |
|------|-------|--------------|
| **Admin** | Full access | - Validasi pembayaran<br>- Kelola data wisata<br>- Kelola user<br>- Lihat laporan |
| **Petugas** | Terbatas | - Scan tiket pengunjung<br>- Lihat riwayat scan |
| **Bendahara** | Terbatas | - Verifikasi transaksi keuangan<br>- Lihat laporan keuangan |
| **Owner** | Read-only | - Monitoring dashboard<br>- Lihat semua laporan |

### 3. Status dan Workflow

**Status Pembayaran:**
- `menunggu` → Baru dibuat, menunggu validasi admin
- `valid` → Divalidasi admin, tiket digenerate
- `tidak_valid` → Ditolak admin

**Status Tiket:**
- `sudah_digunakan = false` → Belum discan
- `sudah_digunakan = true` → Sudah discan, tidak bisa digunakan lagi

**Status Verifikasi Bendahara:**
- `diverifikasi_bendahara = false` → Belum diverifikasi
- `diverifikasi_bendahara = true` → Sudah diverifikasi

---

## Catatan Penting

1. **Cascade Delete:**
   - Jika wisata dihapus → semua galeri_wisata ikut terhapus
   - Jika pemesanan dihapus → semua tiket ikut terhapus

2. **Set Null on Delete:**
   - Jika user dihapus → foreign key di pemesanan/tiket menjadi NULL
   - Data historis tetap tersimpan

3. **Unique Constraints:**
   - `users.email` - Mencegah duplikasi email
   - `pemesanan.kode_pemesanan` - Kode pemesanan unik
   - `tiket.kode_tiket` - Kode tiket unik

4. **Default Values:**
   - Role user default: 'Petugas'
   - Status pembayaran default: 'menunggu'
   - Tiket sudah_digunakan default: false
   - Boolean aktif default: true

---

## Query Contoh

### Mendapatkan semua pemesanan yang valid beserta tiketnya
```sql
SELECT p.*, t.kode_tiket, t.sudah_digunakan
FROM pemesanan p
LEFT JOIN tiket t ON p.id = t.pemesanan_id
WHERE p.status_pembayaran = 'valid'
ORDER BY p.tanggal_kunjungan DESC;
```

### Mendapatkan statistik tiket yang sudah discan
```sql
SELECT 
    COUNT(*) as total_tiket,
    SUM(CASE WHEN sudah_digunakan = 1 THEN 1 ELSE 0 END) as tiket_terpakai,
    SUM(CASE WHEN sudah_digunakan = 0 THEN 1 ELSE 0 END) as tiket_belum_terpakai
FROM tiket
WHERE pemesanan_id IN (
    SELECT id FROM pemesanan WHERE status_pembayaran = 'valid'
);
```

### Laporan pendapatan per tanggal
```sql
SELECT 
    tanggal_kunjungan,
    COUNT(*) as jumlah_pemesanan,
    SUM(total_harga) as total_pendapatan,
    SUM(jumlah_tiket) as total_tiket
FROM pemesanan
WHERE status_pembayaran = 'valid'
GROUP BY tanggal_kunjungan
ORDER BY tanggal_kunjungan DESC;
```

---

**Dibuat:** November 2024  
**Framework:** Laravel 11  
**Database:** MySQL/MariaDB
