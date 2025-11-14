# Aplikasi Pemesanan Tiket Wisata Online

Aplikasi web untuk pemesanan tiket wisata secara online dengan sistem validasi pembayaran dan QR Code untuk verifikasi tiket di pintu masuk.

## Fitur Utama

### 🌐 Landing Page (Public)
- Melihat daftar wisata yang tersedia
- Detail informasi wisata (galeri, deskripsi, harga)
- Form pemesanan tiket online
- Upload bukti transfer pembayaran
- Tracking status pemesanan

### 👨‍💼 Admin
- Dashboard statistik pemesanan dan pendapatan
- Kelola data wisata (CRUD)
- Kelola galeri foto wisata
- Validasi transaksi pembayaran
- Generate QR Code tiket otomatis
- Kirim tiket via email (PDF + QR Code)
- Kelola user/petugas
- Laporan penjualan tiket
- Cetak laporan PDF (hanya data terverifikasi)

### 🎫 Petugas Tiket
- Scan QR Code tiket dengan kamera
- Validasi tiket masuk (sekali pakai)
- Input manual kode tiket
- Riwayat scan tiket

### 💰 Bendahara
- Laporan transaksi valid
- Filter laporan berdasarkan periode
- Verifikasi pendapatan (single & bulk)
- Cetak laporan PDF
- Tracking verifikator dan waktu verifikasi

### 📊 Owner
- Dashboard statistik (harian, mingguan, bulanan)
- Grafik pendapatan dan pengunjung
- Monitoring real-time

## Teknologi

- **Framework**: Laravel 12
- **Database**: MySQL / SQLite
- **Frontend**: 
  - Admin Dashboard: Blade Template + Bootstrap (Vite)
  - Landing Page: Blade Template + Tailwind CSS (CDN)
- **QR Code**: SimpleSoftwareIO/simple-qrcode
- **QR Scanner**: HTML5-QRCode
- **Charts**: Chart.js

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL atau SQLite
- Extension PHP: GD atau Imagick (untuk QR Code)

## Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd tiket-wisata
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
copy .env.example .env
```

Edit file `.env` sesuai konfigurasi database Anda.

### 4. Generate Key & Setup Database

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 5. Build Assets (Opsional untuk Admin Dashboard)

```bash
npm install
npm run build
```

**Catatan:** Landing page menggunakan Tailwind CDN, jadi tidak perlu build. Build hanya diperlukan untuk admin dashboard.

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@wisata.com | password |
| Petugas | petugas@wisata.com | password |
| Bendahara | bendahara@wisata.com | password |
| Owner | owner@wisata.com | password |

## Alur Penggunaan

### Untuk Pengunjung:
1. Buka website dan pilih wisata
2. Isi form pemesanan tiket
3. Transfer pembayaran sesuai nominal
4. Upload bukti transfer
5. Tunggu validasi admin (1-24 jam)
6. Terima tiket via email (PDF dengan QR Code)
7. Tunjukkan QR Code di pintu masuk

### Untuk Admin:
1. Login ke dashboard admin
2. Kelola data wisata dan galeri
3. Cek transaksi yang masuk
4. Validasi bukti transfer
5. Sistem otomatis generate QR Code jika valid
6. Monitor laporan penjualan

### Untuk Petugas:
1. Login ke dashboard petugas
2. Buka menu "Scan Tiket"
3. Scan QR Code pengunjung
4. Sistem validasi otomatis (sekali pakai)
5. Lihat riwayat scan

## Struktur Database

### Tabel Utama:
- `peran` - Role user (Admin, Petugas, Bendahara, Owner)
- `users` - Data user/petugas
- `wisata` - Data tempat wisata
- `galeri_wisata` - Foto-foto wisata
- `pemesanan` - Data pemesanan tiket
- `tiket` - Data tiket dengan QR Code

## Fitur Keamanan

- ✅ Authentication & Authorization berbasis role
- ✅ CSRF Protection
- ✅ Password Hashing
- ✅ File Upload Validation
- ✅ QR Code sekali pakai (tidak bisa digunakan ulang)
- ✅ Validasi pembayaran manual oleh admin

## Dokumentasi Lengkap

- [Panduan Instalasi](PANDUAN_INSTALASI.md)
- [Panduan Penggunaan](PANDUAN_PENGGUNAAN.md)
- [PRD (Product Requirements Document)](prd.md)

## Deployment ke Production

Untuk deploy ke production server, ikuti langkah berikut:

### Quick Deploy
```bash
# Build assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Update .env untuk Production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

📖 **Dokumentasi lengkap:** Lihat [DEPLOYMENT.md](DEPLOYMENT.md)

## Catatan Penting

1. **QR Code Scanner** memerlukan HTTPS atau localhost untuk akses kamera
2. **Email Configuration** perlu diatur di `.env` untuk mengirim tiket
3. **Storage Permission** pastikan folder `storage` dan `bootstrap/cache` writable
4. **Backup Database** lakukan backup secara berkala
5. **Production Mode** set `APP_DEBUG=false` untuk production
6. **Build Assets** jalankan `npm run build` sebelum deploy

## Troubleshooting

### QR Code tidak ter-generate
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:clear
```

### Storage link error
```bash
php artisan storage:link
```

### Permission denied
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Fitur Terbaru ✨

- ✅ **Email Tiket Otomatis** - Kirim tiket PDF dengan QR Code via email
- ✅ **Cetak Laporan PDF** - Export laporan penjualan ke PDF (Admin & Bendahara)
- ✅ **Bulk Verifikasi** - Verifikasi multiple transaksi sekaligus (Bendahara)
- ✅ **Tracking Verifikasi** - Catat siapa dan kapan verifikasi dilakukan
- ✅ **Toggle Password** - Show/hide password di halaman login
- ✅ **Demo Credentials** - Tampilkan akun demo di halaman login

## Pengembangan Lebih Lanjut

Fitur yang bisa ditambahkan:
- [ ] Notifikasi WhatsApp
- [ ] Payment Gateway integration
- [ ] Export laporan ke Excel
- [ ] Multi-bahasa
- [ ] Mobile app
- [ ] Review & rating wisata
- [ ] Promo & diskon
- [ ] Booking calendar
- [ ] Refund system

## Lisensi

MIT License

## Support

Untuk pertanyaan atau bantuan, silakan hubungi developer atau buat issue di repository.

---

**Dibuat dengan ❤️ menggunakan Laravel**
