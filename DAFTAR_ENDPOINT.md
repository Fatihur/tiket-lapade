# Daftar Endpoint Aplikasi

## Public Routes (Tanpa Login)

### Landing Page
- `GET /` - Halaman utama
- `GET /wisata/{id}` - Detail wisata

### Pemesanan
- `GET /pemesanan/{wisataId}` - Form pemesanan tiket
- `POST /pemesanan` - Submit pemesanan
- `GET /pemesanan/sukses/{id}` - Halaman sukses pemesanan

### Authentication
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `POST /logout` - Logout

---

## Admin Routes (Role: Admin)

Prefix: `/admin`

### Dashboard
- `GET /admin/dashboard` - Dashboard admin

### Kelola Wisata
- `GET /admin/wisata` - Lihat data wisata
- `GET /admin/wisata/{id}/edit` - Form edit wisata
- `PUT /admin/wisata/{id}` - Update data wisata
- `POST /admin/wisata/{id}/galeri` - Upload foto galeri
- `DELETE /admin/galeri/{id}` - Hapus foto galeri

### Transaksi
- `GET /admin/transaksi` - Daftar transaksi
- `GET /admin/transaksi/{id}` - Detail transaksi
- `POST /admin/transaksi/{id}/validasi` - Validasi pembayaran

### Laporan
- `GET /admin/laporan` - Laporan penjualan

### User Management
- `GET /admin/user` - Daftar user
- `GET /admin/user/create` - Form tambah user
- `POST /admin/user` - Simpan user baru
- `GET /admin/user/{id}/edit` - Form edit user
- `PUT /admin/user/{id}` - Update user
- `DELETE /admin/user/{id}` - Hapus user

---

## Petugas Routes (Role: Petugas)

Prefix: `/petugas`

### Dashboard
- `GET /petugas/dashboard` - Dashboard petugas

### Scan Tiket
- `GET /petugas/scan` - Halaman scan QR Code
- `POST /petugas/scan` - Proses scan QR Code
- `GET /petugas/riwayat` - Riwayat scan

---

## Bendahara Routes (Role: Bendahara)

Prefix: `/bendahara`

### Dashboard
- `GET /bendahara/dashboard` - Dashboard bendahara (laporan keuangan)

---

## Owner Routes (Role: Owner)

Prefix: `/owner`

### Dashboard
- `GET /owner/dashboard` - Dashboard owner (overview & laporan)

---

## Middleware

### Auth
Semua route dengan prefix `/admin`, `/petugas`, `/bendahara`, `/owner` memerlukan login.

### Role
- Admin routes: `middleware(['auth', 'role:Admin'])`
- Petugas routes: `middleware(['auth', 'role:Petugas'])`
- Bendahara routes: `middleware(['auth', 'role:Bendahara'])`
- Owner routes: `middleware(['auth', 'role:Owner'])`

---

## Response Format

### Success Response
```json
{
    "success": true,
    "message": "Operasi berhasil",
    "data": {}
}
```

### Error Response
```json
{
    "success": false,
    "message": "Pesan error",
    "errors": {}
}
```

### Redirect Response
Kebanyakan form menggunakan redirect dengan flash message:
```php
return redirect()->route('route.name')->with('success', 'Pesan sukses');
return redirect()->back()->with('error', 'Pesan error');
```

---

## File Upload

### Bukti Transfer (Pemesanan)
- Path: `storage/app/public/bukti_transfer/`
- Max size: 2MB
- Format: jpg, jpeg, png

### Galeri Wisata
- Path: `storage/app/public/galeri_wisata/`
- Max size: 2MB
- Format: jpg, jpeg, png

---

## Email

### Tiket Email
Dikirim otomatis setelah admin validasi pembayaran.

**To:** Email pemesan
**Subject:** Tiket Wisata - [Kode Tiket]
**Attachment:** PDF tiket dengan QR Code

---

## QR Code Format

QR Code berisi data JSON:
```json
{
    "kode_tiket": "TKT-XXXXXXXXXX",
    "nama_pemesan": "Nama Pemesan",
    "wisata": "Nama Wisata",
    "tanggal_kunjungan": "2024-01-01",
    "jumlah_dewasa": 2,
    "jumlah_anak": 1
}
```

Format: SVG base64 encoded
