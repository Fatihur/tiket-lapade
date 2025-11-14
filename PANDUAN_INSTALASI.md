# Panduan Instalasi Aplikasi Tiket Wisata Online

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL atau SQLite
- Web Server (Apache/Nginx) atau PHP Development Server

## Langkah Instalasi

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Konfigurasi Environment

Copy file `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

Atau gunakan SQLite (sudah dikonfigurasi default):

```
DB_CONNECTION=sqlite
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Jalankan Migrasi Database

```bash
php artisan migrate
```

### 5. Jalankan Seeder (Data Awal)

```bash
php artisan db:seed
```

Seeder akan membuat:
- 4 Role: Admin, Petugas, Bendahara, Owner
- 4 User default dengan password: `password`
  - admin@wisata.com (Admin)
  - petugas@wisata.com (Petugas)
  - bendahara@wisata.com (Bendahara)
  - owner@wisata.com (Owner)

### 6. Buat Storage Link

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
npm run build
```

Atau untuk development:

```bash
npm run dev
```

### 8. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## Akun Default

Setelah instalasi, Anda dapat login dengan akun berikut:

### Admin
- Email: admin@wisata.com
- Password: password

### Petugas Tiket
- Email: petugas@wisata.com
- Password: password

### Bendahara
- Email: bendahara@wisata.com
- Password: password

### Owner
- Email: owner@wisata.com
- Password: password

## Konfigurasi Email (Opsional)

Untuk mengirim tiket via email, edit konfigurasi email di `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email@gmail.com
MAIL_PASSWORD=password_aplikasi
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Troubleshooting

### Error: Class 'SimpleSoftwareIO\QrCode\Facades\QrCode' not found

Jalankan:
```bash
composer require simplesoftwareio/simple-qrcode
```

### Error: Storage link tidak berfungsi

Jalankan ulang:
```bash
php artisan storage:link
```

### Error: Permission denied pada folder storage

Berikan permission:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Struktur Folder Penting

- `app/Models` - Model database
- `app/Http/Controllers` - Controller untuk setiap role
- `database/migrations` - File migrasi database
- `resources/views` - File view/tampilan
- `routes/web.php` - Routing aplikasi
- `public/storage` - Folder untuk file upload (gambar, bukti transfer, QR code)

## Fitur Aplikasi

### Landing Page (Public)
- Melihat daftar wisata
- Detail wisata
- Form pemesanan tiket
- Upload bukti transfer

### Admin
- Dashboard statistik
- Kelola data wisata (CRUD)
- Kelola galeri wisata
- Validasi transaksi pemesanan
- Kelola user/petugas
- Laporan penjualan tiket

### Petugas Tiket
- Scan QR Code tiket
- Validasi tiket masuk
- Riwayat scan tiket

### Bendahara
- Lihat laporan transaksi
- Verifikasi laporan penjualan

### Owner
- Dashboard laporan (harian, mingguan, bulanan)
- Statistik pengunjung dan pendapatan
- Grafik penjualan

## Catatan Penting

1. Pastikan folder `storage` dan `bootstrap/cache` memiliki permission write
2. Untuk production, jangan lupa set `APP_DEBUG=false` di `.env`
3. Generate QR Code memerlukan library GD atau Imagick di PHP
4. Scan QR Code di browser memerlukan HTTPS atau localhost
5. Backup database secara berkala

## Support

Jika ada pertanyaan atau masalah, silakan hubungi developer.
