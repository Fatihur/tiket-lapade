# Quick Start Guide - Aplikasi Tiket Wisata

## 🚀 Instalasi Cepat (5 Menit)

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### 3. Setup Database
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 4. Build & Run
```bash
npm run build
php artisan serve
```

### 5. Akses Aplikasi
- **Landing Page**: http://localhost:8000
- **Login Admin**: http://localhost:8000/login

## 🔑 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@wisata.com | password |
| Petugas | petugas@wisata.com | password |
| Bendahara | bendahara@wisata.com | password |
| Owner | owner@wisata.com | password |

## 📝 Langkah Pertama Setelah Instalasi

### Sebagai Admin:

1. **Login** ke dashboard admin
2. **Tambah Data Wisata**:
   - Menu: Wisata → Tambah Wisata
   - Isi: Nama, deskripsi, harga tiket, info rekening
   - Simpan
3. **Upload Foto Wisata**:
   - Buka detail wisata
   - Upload gambar (centang "Gambar Utama" untuk cover)
4. **Cek Landing Page**:
   - Logout atau buka incognito
   - Lihat wisata yang baru ditambahkan

### Test Pemesanan:

1. **Buat Pemesanan**:
   - Buka landing page
   - Pilih wisata → Pesan Tiket
   - Isi form pemesanan
   - Upload gambar dummy sebagai bukti transfer
   - Submit

2. **Validasi Pemesanan**:
   - Login sebagai admin
   - Menu: Transaksi
   - Klik Detail pada pemesanan
   - Validasi sebagai "Valid"
   - QR Code akan ter-generate otomatis

3. **Scan Tiket**:
   - Login sebagai petugas
   - Menu: Scan Tiket
   - Input kode tiket secara manual (copy dari database)
   - Atau scan QR Code jika ada

## 🎯 Fitur Utama

### Public (Pengunjung)
- ✅ Lihat daftar wisata
- ✅ Pesan tiket online
- ✅ Upload bukti transfer
- ✅ Terima tiket via email (jika email dikonfigurasi)

### Admin
- ✅ Kelola wisata & galeri
- ✅ Validasi transaksi
- ✅ Generate QR Code otomatis
- ✅ Kelola user/petugas
- ✅ Laporan penjualan

### Petugas
- ✅ Scan QR Code tiket
- ✅ Validasi tiket masuk
- ✅ Riwayat scan

### Bendahara
- ✅ Laporan transaksi
- ✅ Verifikasi pendapatan

### Owner
- ✅ Dashboard statistik
- ✅ Grafik penjualan
- ✅ Monitor pengunjung

## 🔧 Konfigurasi Tambahan (Opsional)

### Email (Untuk Kirim Tiket)
Edit `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com
```

### Database MySQL (Default: SQLite)
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tiket_wisata
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan ulang:
```bash
php artisan migrate:fresh --seed
```

## 📱 Scan QR Code

### Untuk Testing di Localhost:
1. QR Scanner memerlukan HTTPS atau localhost
2. Jika menggunakan HP untuk scan:
   - Pastikan HP dan laptop di jaringan yang sama
   - Akses via IP laptop (misal: http://192.168.1.100:8000)
   - Browser akan minta izin kamera

### Alternatif: Input Manual
- Jika scan gagal, gunakan input manual
- Copy kode tiket dari database atau email
- Paste di form input manual

## 🐛 Troubleshooting Cepat

### Error: Class 'QrCode' not found
```bash
composer require simplesoftwareio/simple-qrcode
```

### Error: Storage link
```bash
php artisan storage:link
```

### Error: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

### Gambar tidak muncul
```bash
php artisan storage:link
# Refresh browser dengan Ctrl+F5
```

## 📚 Dokumentasi Lengkap

- [README.md](README.md) - Overview aplikasi
- [PANDUAN_INSTALASI.md](PANDUAN_INSTALASI.md) - Instalasi detail
- [PANDUAN_PENGGUNAAN.md](PANDUAN_PENGGUNAAN.md) - Cara penggunaan
- [STRUKTUR_APLIKASI.md](STRUKTUR_APLIKASI.md) - Struktur kode
- [CHECKLIST_INSTALASI.md](CHECKLIST_INSTALASI.md) - Checklist lengkap

## 💡 Tips

1. **Ganti Password Default** setelah instalasi
2. **Backup Database** secara berkala
3. **Test Semua Fitur** sebelum production
4. **Set APP_DEBUG=false** untuk production
5. **Gunakan HTTPS** untuk production

## 🎉 Selamat!

Aplikasi siap digunakan! Jika ada pertanyaan, silakan cek dokumentasi lengkap atau hubungi developer.

---

**Happy Coding! 🚀**
