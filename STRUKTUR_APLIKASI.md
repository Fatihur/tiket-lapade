# Struktur Aplikasi Tiket Wisata Online

## Struktur Folder

```
tiket-lapade/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── WisataController.php
│   │   │   │   ├── TransaksiController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Petugas/
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── ScanController.php
│   │   │   ├── Bendahara/
│   │   │   │   └── DashboardController.php
│   │   │   ├── Owner/
│   │   │   │   └── DashboardController.php
│   │   │   ├── AuthController.php
│   │   │   ├── LandingController.php
│   │   │   └── PemesananController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Peran.php
│       ├── Wisata.php
│       ├── GaleriWisata.php
│       ├── Pemesanan.php
│       └── Tiket.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000003_create_roles_table.php
│   │   ├── 2024_01_01_000004_update_users_table.php
│   │   ├── 2024_01_01_000005_create_wisata_table.php
│   │   ├── 2024_01_01_000006_create_galeri_wisata_table.php
│   │   ├── 2024_01_01_000007_create_pemesanan_table.php
│   │   └── 2024_01_01_000008_create_tiket_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── PeranSeeder.php
│       └── UserSeeder.php
├── resources/
│   └── views/
│       ├── landing/
│       │   ├── index.blade.php
│       │   ├── detail.blade.php
│       │   ├── pemesanan.blade.php
│       │   └── sukses.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── wisata/
│       │   │   ├── index.blade.php
│       │   │   └── create.blade.php
│       │   └── transaksi/
│       │       ├── index.blade.php
│       │       └── detail.blade.php
│       ├── petugas/
│       │   ├── dashboard.blade.php
│       │   └── scan.blade.php
│       ├── bendahara/
│       │   └── dashboard.blade.php
│       └── owner/
│           └── dashboard.blade.php
├── routes/
│   └── web.php
└── storage/
    └── app/
        └── public/
            ├── bukti_transfer/
            ├── galeri_wisata/
            └── qrcodes/
```

## Database Schema

### Tabel: peran
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| nama_peran | varchar | Admin, Petugas, Bendahara, Owner |

### Tabel: users
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| name | varchar | Nama user |
| email | varchar | Email (unique) |
| password | varchar | Password (hashed) |
| peran_id | bigint | Foreign Key ke peran |
| nomor_telepon | varchar | Nomor telepon |
| aktif | boolean | Status aktif |

### Tabel: wisata
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| nama_wisata | varchar | Nama tempat wisata |
| deskripsi | text | Deskripsi wisata |
| harga_tiket_dewasa | decimal | Harga tiket dewasa |
| harga_tiket_anak | decimal | Harga tiket anak |
| biaya_parkir_motor | decimal | Biaya parkir motor |
| biaya_parkir_mobil | decimal | Biaya parkir mobil |
| nomor_rekening | varchar | Nomor rekening |
| nama_bank | varchar | Nama bank |
| atas_nama | varchar | Atas nama rekening |
| email_kontak | varchar | Email kontak |
| nomor_whatsapp | varchar | Nomor WhatsApp |
| aktif | boolean | Status aktif |

### Tabel: galeri_wisata
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| wisata_id | bigint | Foreign Key ke wisata |
| nama_file | varchar | Nama file gambar |
| path_file | varchar | Path file |
| keterangan | varchar | Keterangan gambar |
| utama | boolean | Gambar utama |

### Tabel: pemesanan
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| kode_pemesanan | varchar | Kode unik pemesanan |
| wisata_id | bigint | Foreign Key ke wisata |
| nama_pemesan | varchar | Nama pemesan |
| email_pemesan | varchar | Email pemesan |
| nomor_whatsapp | varchar | Nomor WhatsApp |
| tanggal_kunjungan | date | Tanggal kunjungan |
| jumlah_tiket_dewasa | integer | Jumlah tiket dewasa |
| jumlah_tiket_anak | integer | Jumlah tiket anak |
| jumlah_parkir_motor | integer | Jumlah parkir motor |
| jumlah_parkir_mobil | integer | Jumlah parkir mobil |
| total_harga | decimal | Total harga |
| bukti_transfer | varchar | Path bukti transfer |
| status_pembayaran | enum | menunggu, valid, tidak_valid |
| catatan_admin | text | Catatan dari admin |
| divalidasi_oleh | bigint | Foreign Key ke users |
| tanggal_validasi | timestamp | Tanggal validasi |

### Tabel: tiket
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| pemesanan_id | bigint | Foreign Key ke pemesanan |
| kode_tiket | varchar | Kode unik tiket |
| qr_code_path | varchar | Path QR Code |
| jenis_tiket | enum | dewasa, anak |
| sudah_digunakan | boolean | Status penggunaan |
| tanggal_scan | timestamp | Tanggal scan |
| discan_oleh | bigint | Foreign Key ke users |

## Routing

### Public Routes
- `GET /` - Landing page
- `GET /wisata/{id}` - Detail wisata
- `GET /pemesanan/{wisataId}` - Form pemesanan
- `POST /pemesanan` - Submit pemesanan
- `GET /pemesanan/sukses/{id}` - Halaman sukses

### Auth Routes
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `POST /logout` - Logout

### Admin Routes (Middleware: auth, role:Admin)
- `GET /admin/dashboard` - Dashboard admin
- `GET /admin/wisata` - Daftar wisata
- `POST /admin/wisata` - Tambah wisata
- `GET /admin/wisata/{id}/edit` - Edit wisata
- `DELETE /admin/wisata/{id}` - Hapus wisata
- `GET /admin/transaksi` - Daftar transaksi
- `GET /admin/transaksi/{id}` - Detail transaksi
- `POST /admin/transaksi/{id}/validasi` - Validasi transaksi
- `GET /admin/laporan` - Laporan penjualan
- `GET /admin/user` - Daftar user

### Petugas Routes (Middleware: auth, role:Petugas)
- `GET /petugas/dashboard` - Dashboard petugas
- `GET /petugas/scan` - Halaman scan
- `POST /petugas/scan` - Proses scan
- `GET /petugas/riwayat` - Riwayat scan

### Bendahara Routes (Middleware: auth, role:Bendahara)
- `GET /bendahara/dashboard` - Dashboard bendahara

### Owner Routes (Middleware: auth, role:Owner)
- `GET /owner/dashboard` - Dashboard owner

## Alur Proses Bisnis

### 1. Pemesanan Tiket
```
Pengunjung → Pilih Wisata → Isi Form → Upload Bukti Transfer → Submit
→ Status: Menunggu Validasi
```

### 2. Validasi Admin
```
Admin → Lihat Transaksi → Cek Bukti Transfer → Validasi (Valid/Tidak Valid)
→ Jika Valid: Generate QR Code Tiket → Kirim Email (opsional)
```

### 3. Scan Tiket
```
Pengunjung Datang → Tunjukkan QR Code → Petugas Scan
→ Validasi: Tiket Valid & Belum Digunakan → Izinkan Masuk
→ Tiket Ditandai Sudah Digunakan (Tidak Bisa Dipakai Lagi)
```

## Fitur Keamanan

1. **Authentication**: Laravel Breeze/Sanctum
2. **Authorization**: Middleware CheckRole
3. **CSRF Protection**: Token CSRF di semua form
4. **Password Hashing**: Bcrypt
5. **File Upload Validation**: Tipe & ukuran file
6. **QR Code Sekali Pakai**: Flag sudah_digunakan

## Dependencies Utama

### Composer (PHP)
- laravel/framework: ^12.0
- simplesoftwareio/simple-qrcode: ^4.2

### NPM (JavaScript)
- html5-qrcode: Scanner QR Code
- chart.js: Grafik statistik
- tailwindcss: CSS framework

## Environment Variables Penting

```env
APP_NAME=Tiket Wisata Online
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_DATABASE=tiket_wisata

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

## Catatan Pengembangan

### Untuk Menambah Fitur Baru:
1. Buat migration: `php artisan make:migration create_xxx_table`
2. Buat model: `php artisan make:model NamaModel`
3. Buat controller: `php artisan make:controller NamaController`
4. Tambahkan route di `routes/web.php`
5. Buat view di `resources/views/`

### Untuk Testing:
```bash
php artisan test
```

### Untuk Deploy Production:
1. Set `APP_DEBUG=false`
2. Set `APP_ENV=production`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Set proper file permissions
7. Configure web server (Apache/Nginx)
