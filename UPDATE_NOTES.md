# Update Notes - Simplifikasi Database

## Perubahan yang Dilakukan

### Database Schema
1. **Tabel Wisata**
   - ❌ Dihapus: `nama_wisata`
   - ❌ Dihapus: `harga_tiket_dewasa`
   - ❌ Dihapus: `harga_tiket_anak`
   - ✅ Ditambah: `harga_tiket`

2. **Tabel Pemesanan**
   - ❌ Dihapus: `wisata_id` (foreign key)
   - ❌ Dihapus: `jumlah_tiket_dewasa`
   - ❌ Dihapus: `jumlah_tiket_anak`
   - ✅ Ditambah: `jumlah_tiket`

### Files yang Sudah Diupdate
- ✅ database/migrations/2024_01_01_000005_create_wisata_table.php
- ✅ database/migrations/2024_01_01_000007_create_pemesanan_table.php
- ✅ app/Models/Wisata.php
- ✅ app/Models/Pemesanan.php
- ✅ database/seeders/WisataSeeder.php
- ✅ app/Http/Controllers/PemesananController.php (partial)
- ✅ app/Http/Controllers/Admin/WisataController.php (partial)

### Files yang Perlu Diupdate
Karena banyaknya file yang perlu diupdate, berikut adalah panduan manual untuk update:

#### Views yang Perlu Diupdate
1. **Landing Pages** - Ganti semua referensi:
   - `$wisata->nama_wisata` → Hapus atau ganti dengan nama statis
   - `$wisata->harga_tiket_dewasa` → `$wisata->harga_tiket`
   - `$wisata->harga_tiket_anak` → Hapus
   - `$pemesanan->wisata->nama_wisata` → Hapus atau ganti dengan nama statis
   - `jumlah_tiket_dewasa` → `jumlah_tiket`
   - `jumlah_tiket_anak` → Hapus

2. **Admin Views** - Ganti semua referensi yang sama

3. **Email & PDF Templates** - Ganti semua referensi yang sama

#### Controllers yang Perlu Diupdate
- app/Http/Controllers/Admin/TransaksiController.php
- app/Http/Controllers/Admin/LaporanController.php
- app/Http/Controllers/Owner/DashboardController.php
- app/Http/Controllers/Petugas/ScanController.php

## Cara Cepat Update

Gunakan Find & Replace di editor:

1. Find: `->nama_wisata` → Replace: (hapus atau ganti dengan string statis)
2. Find: `->harga_tiket_dewasa` → Replace: `->harga_tiket`
3. Find: `->harga_tiket_anak` → Replace: (hapus)
4. Find: `jumlah_tiket_dewasa` → Replace: `jumlah_tiket`
5. Find: `jumlah_tiket_anak` → Replace: (hapus atau set 0)
6. Find: `wisata_id` → Replace: (hapus dari form/validation)
7. Find: `$pemesanan->wisata->` → Replace: (hapus relasi wisata)

## Testing Setelah Update

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Test semua fitur:
- Landing page
- Form pemesanan
- Admin panel
- Email & PDF
- Scan QR Code
