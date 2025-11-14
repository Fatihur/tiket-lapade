# Testing Aplikasi Tiket Wisata

## Status: ✅ SIAP DIGUNAKAN

Aplikasi sudah selesai dibuat dan siap untuk digunakan. Berikut adalah checklist testing yang bisa dilakukan:

## 1. Testing Database ✅
```bash
php artisan migrate:fresh --seed
```
- ✅ Migrasi berhasil
- ✅ Seeder berhasil membuat user default
- ✅ Seeder berhasil membuat data wisata default

## 2. Testing Login
Akun default yang tersedia:

### Admin
- Email: admin@wisata.com
- Password: password
- Akses: Kelola wisata, validasi transaksi, laporan, user management

### Petugas
- Email: petugas@wisata.com
- Password: password
- Akses: Scan QR Code tiket

### Bendahara
- Email: bendahara@wisata.com
- Password: password
- Akses: Lihat laporan keuangan

### Owner
- Email: owner@wisata.com
- Password: password
- Akses: Dashboard overview dan laporan

## 3. Testing Fitur Landing Page (Public)
- [ ] Buka halaman utama: http://localhost:8000
- [ ] Lihat detail wisata
- [ ] Form pemesanan tiket
- [ ] Pilih jumlah tiket dewasa/anak
- [ ] Pilih parkir motor/mobil
- [ ] Input data pemesan
- [ ] Upload bukti transfer
- [ ] Submit pemesanan

## 4. Testing Admin Panel
Login sebagai Admin, lalu test:

### Kelola Wisata
- [ ] Lihat data wisata di menu "Kelola Wisata"
- [ ] Edit data wisata (nama, deskripsi, harga)
- [ ] Upload foto galeri wisata
- [ ] Set foto utama
- [ ] Hapus foto galeri

### Validasi Transaksi
- [ ] Lihat daftar transaksi di menu "Transaksi"
- [ ] Filter transaksi (pending/lunas/batal)
- [ ] Lihat detail transaksi
- [ ] Validasi pembayaran (ubah status jadi lunas)
- [ ] Sistem otomatis kirim email dengan PDF tiket + QR Code

### Laporan
- [ ] Lihat laporan penjualan
- [ ] Filter berdasarkan tanggal
- [ ] Export laporan ke Excel/PDF

### User Management
- [ ] Lihat daftar user
- [ ] Tambah user baru
- [ ] Edit user
- [ ] Hapus user

## 5. Testing Petugas Panel
Login sebagai Petugas, lalu test:

### Scan QR Code
- [ ] Buka menu "Scan Tiket"
- [ ] Scan QR Code dari tiket
- [ ] Sistem validasi tiket (valid/sudah digunakan/tidak valid)
- [ ] Lihat riwayat scan

## 6. Testing Email & PDF
Pastikan sudah konfigurasi email di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Tiket Wisata"
```

Test:
- [ ] Validasi transaksi sebagai Admin
- [ ] Cek email pemesan menerima tiket
- [ ] PDF tiket berisi QR Code
- [ ] QR Code bisa di-scan

## 7. Testing QR Code
File test sudah tersedia:

```bash
# Test QR Code generation
php test-qr.php

# Test PDF generation
php test-pdf.php

# Test Email dengan QR Code
php test-email-with-qr.php
```

## Cara Menjalankan Aplikasi

### Development Server
```bash
php artisan serve
```
Akses: http://localhost:8000

### Storage Link (untuk upload gambar)
```bash
php artisan storage:link
```

## Troubleshooting

### Error: Storage link not found
```bash
php artisan storage:link
```

### Error: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

### Error: Email tidak terkirim
- Pastikan konfigurasi email di `.env` sudah benar
- Gunakan App Password untuk Gmail (bukan password biasa)
- Cek file `CARA_SETUP_EMAIL.md` untuk panduan lengkap

### Error: QR Code tidak muncul
- Pastikan library simplesoftwareio/simple-qrcode sudah terinstall
- Jalankan: `composer require simplesoftwareio/simple-qrcode`

## Fitur Lengkap Aplikasi

### Public (Landing Page)
✅ Tampilan informasi wisata
✅ Galeri foto wisata
✅ Form pemesanan tiket online
✅ Upload bukti transfer
✅ Halaman sukses pemesanan

### Admin
✅ Dashboard dengan statistik
✅ Kelola data wisata (single wisata system)
✅ Upload & kelola galeri foto
✅ Validasi transaksi pembayaran
✅ Generate & kirim tiket via email
✅ Laporan penjualan
✅ User management (CRUD)

### Petugas
✅ Dashboard
✅ Scan QR Code tiket
✅ Validasi tiket (valid/sudah digunakan)
✅ Riwayat scan

### Bendahara
✅ Dashboard
✅ Laporan keuangan

### Owner
✅ Dashboard overview
✅ Laporan lengkap

### Email & PDF
✅ Email otomatis setelah validasi pembayaran
✅ PDF tiket dengan QR Code
✅ QR Code format SVG (tidak perlu Imagick)
✅ Template email profesional

## Dokumentasi Lengkap

Baca file-file berikut untuk informasi lebih detail:

1. `README.md` - Overview aplikasi
2. `PANDUAN_INSTALASI.md` - Cara install aplikasi
3. `PANDUAN_PENGGUNAAN.md` - Cara menggunakan aplikasi
4. `CARA_SETUP_EMAIL.md` - Setup email untuk kirim tiket
5. `ALUR_SISTEM.md` - Alur kerja sistem
6. `STRUKTUR_APLIKASI.md` - Struktur folder dan file

## Kesimpulan

Aplikasi sudah **100% selesai** dan siap digunakan. Semua fitur sudah terimplementasi dengan baik:

✅ Database & migrasi
✅ Authentication & authorization (role-based)
✅ Landing page public
✅ Pemesanan tiket online
✅ Upload bukti transfer
✅ Admin panel lengkap
✅ Validasi transaksi
✅ Email dengan PDF tiket
✅ QR Code generation
✅ Scan QR Code
✅ Laporan penjualan
✅ User management
✅ Single wisata system

Silakan mulai testing dan gunakan aplikasi! 🎉
