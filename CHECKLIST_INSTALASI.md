# Checklist Instalasi & Setup Aplikasi Tiket Wisata

## ✅ Persiapan Awal

- [ ] PHP 8.2 atau lebih tinggi terinstall
- [ ] Composer terinstall
- [ ] Node.js & NPM terinstall
- [ ] MySQL/SQLite terinstall
- [ ] Git terinstall (opsional)

## ✅ Instalasi Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

## ✅ Konfigurasi Environment

```bash
# Copy file environment
copy .env.example .env

# Generate application key
php artisan key:generate
```

Edit file `.env`:
- [ ] Set `APP_NAME` sesuai nama aplikasi
- [ ] Set `APP_URL` sesuai URL aplikasi
- [ ] Konfigurasi database (DB_CONNECTION, DB_DATABASE, dll)
- [ ] Konfigurasi email (MAIL_MAILER, MAIL_HOST, dll) - opsional

## ✅ Setup Database

```bash
# Jalankan migrasi
php artisan migrate

# Jalankan seeder (data awal)
php artisan db:seed

# Buat symbolic link untuk storage
php artisan storage:link
```

Verifikasi:
- [ ] Semua tabel berhasil dibuat
- [ ] Data role dan user default berhasil dibuat
- [ ] Folder `public/storage` ter-link ke `storage/app/public`

## ✅ Build Assets

```bash
# Production build
npm run build

# Atau untuk development
npm run dev
```

## ✅ Permissions (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## ✅ Testing Aplikasi

### 1. Jalankan Server
```bash
php artisan serve
```

### 2. Test Landing Page
- [ ] Buka `http://localhost:8000`
- [ ] Pastikan halaman landing muncul
- [ ] Cek apakah ada error di console browser

### 3. Test Login Admin
- [ ] Buka `http://localhost:8000/login`
- [ ] Login dengan: admin@wisata.com / password
- [ ] Pastikan redirect ke dashboard admin
- [ ] Cek menu-menu admin berfungsi

### 4. Test Tambah Wisata
- [ ] Login sebagai admin
- [ ] Buka menu Wisata → Tambah Wisata
- [ ] Isi form dan simpan
- [ ] Pastikan data tersimpan
- [ ] Upload gambar galeri
- [ ] Cek gambar muncul di landing page

### 5. Test Pemesanan Tiket
- [ ] Logout dari admin
- [ ] Buka landing page
- [ ] Pilih wisata dan klik "Pesan Tiket"
- [ ] Isi form pemesanan
- [ ] Upload bukti transfer (gambar dummy)
- [ ] Submit pemesanan
- [ ] Pastikan muncul halaman sukses dengan kode pemesanan

### 6. Test Validasi Transaksi
- [ ] Login sebagai admin
- [ ] Buka menu Transaksi
- [ ] Cari pemesanan yang baru dibuat
- [ ] Klik Detail
- [ ] Lihat bukti transfer
- [ ] Validasi sebagai "Valid"
- [ ] Pastikan status berubah menjadi Valid
- [ ] Cek apakah QR Code ter-generate di `storage/app/public/qrcodes/`

### 7. Test Scan Tiket
- [ ] Login sebagai petugas (petugas@wisata.com / password)
- [ ] Buka menu Scan Tiket
- [ ] Izinkan akses kamera (jika diminta)
- [ ] Atau gunakan input manual dengan kode tiket
- [ ] Pastikan validasi berhasil
- [ ] Coba scan/input kode yang sama lagi
- [ ] Pastikan muncul error "Tiket sudah digunakan"

### 8. Test Role Lainnya
- [ ] Login sebagai bendahara (bendahara@wisata.com / password)
- [ ] Pastikan hanya bisa akses dashboard bendahara
- [ ] Login sebagai owner (owner@wisata.com / password)
- [ ] Pastikan bisa lihat statistik dan grafik

## ✅ Konfigurasi Production (Opsional)

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

Edit `.env`:
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_URL` ke domain production

## ✅ Backup & Security

- [ ] Setup backup database otomatis
- [ ] Ganti semua password default
- [ ] Setup SSL/HTTPS untuk production
- [ ] Setup firewall
- [ ] Disable directory listing
- [ ] Setup monitoring & logging

## ✅ Dokumentasi

- [ ] Baca [README.md](README.md)
- [ ] Baca [PANDUAN_INSTALASI.md](PANDUAN_INSTALASI.md)
- [ ] Baca [PANDUAN_PENGGUNAAN.md](PANDUAN_PENGGUNAAN.md)
- [ ] Baca [STRUKTUR_APLIKASI.md](STRUKTUR_APLIKASI.md)

## ✅ Troubleshooting Common Issues

### Issue: QR Code tidak ter-generate
**Solusi:**
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:clear
```

### Issue: Storage link error
**Solusi:**
```bash
# Hapus link lama jika ada
rm public/storage

# Buat link baru
php artisan storage:link
```

### Issue: Permission denied
**Solusi:**
```bash
# Linux/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Windows: Run as Administrator
```

### Issue: Class not found
**Solusi:**
```bash
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
```

### Issue: CSRF token mismatch
**Solusi:**
```bash
php artisan cache:clear
php artisan config:clear
# Clear browser cookies
```

### Issue: Gambar tidak muncul
**Solusi:**
- Pastikan `php artisan storage:link` sudah dijalankan
- Cek permission folder `storage/app/public`
- Cek path di database sudah benar

### Issue: Email tidak terkirim
**Solusi:**
- Cek konfigurasi MAIL di `.env`
- Untuk Gmail, gunakan App Password bukan password biasa
- Test dengan: `php artisan tinker` → `Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });`

## ✅ Maintenance

### Backup Database
```bash
# MySQL
mysqldump -u username -p database_name > backup.sql

# SQLite
copy database\database.sqlite backup\database_backup.sqlite
```

### Update Dependencies
```bash
composer update
npm update
```

### Clear All Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## ✅ Selesai!

Jika semua checklist sudah ✅, aplikasi siap digunakan!

Untuk pertanyaan lebih lanjut, silakan hubungi developer atau buat issue di repository.
