# Konfigurasi Email untuk Mengirim Tiket

## Fitur Email Tiket

Setelah admin memvalidasi pembayaran sebagai "Valid", sistem akan otomatis:
1. Generate QR Code untuk setiap tiket
2. Mengirim email ke pengunjung berisi:
   - Detail pemesanan
   - QR Code tiket (dapat di-scan di pintu masuk)
   - Informasi penting tentang penggunaan tiket

## Konfigurasi Email

### 1. Menggunakan Gmail (Recommended)

Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email-anda@gmail.com
MAIL_PASSWORD=password-aplikasi-anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email-anda@gmail.com
MAIL_FROM_NAME="Tiket Wisata Online"
```

#### Cara Mendapatkan Password Aplikasi Gmail:

1. Buka [Google Account](https://myaccount.google.com/)
2. Pilih **Security** (Keamanan)
3. Aktifkan **2-Step Verification** (Verifikasi 2 Langkah)
4. Scroll ke bawah, pilih **App passwords** (Password aplikasi)
5. Pilih aplikasi: **Mail**
6. Pilih perangkat: **Other** (Lainnya)
7. Beri nama: "Laravel Tiket Wisata"
8. Klik **Generate**
9. Copy password 16 digit yang muncul
10. Paste ke `MAIL_PASSWORD` di file `.env`

**Catatan:** Jangan gunakan password Gmail biasa, harus menggunakan App Password!

### 2. Menggunakan Mailtrap (Untuk Testing)

Mailtrap adalah layanan untuk testing email tanpa mengirim email sungguhan.

Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username-mailtrap-anda
MAIL_PASSWORD=password-mailtrap-anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="Tiket Wisata Online"
```

Cara mendapatkan kredensial Mailtrap:
1. Daftar di [Mailtrap.io](https://mailtrap.io/)
2. Buat inbox baru
3. Copy kredensial SMTP
4. Paste ke file `.env`

### 3. Menggunakan Mailgun

Edit file `.env`:

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-secret
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Tiket Wisata Online"
```

### 4. Menggunakan SendGrid

Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Tiket Wisata Online"
```

## Testing Email

### 1. Test via Tinker

```bash
php artisan tinker
```

Kemudian jalankan:

```php
Mail::raw('Test email', function($message) {
    $message->to('fatihur17@gmail.com')
            ->subject('Test Email');
});
```

Jika berhasil, akan muncul: `=> null` (tanpa error)

### 2. Test dengan Pemesanan Real

1. Buat pemesanan baru dari landing page
2. Upload bukti transfer
3. Login sebagai admin
4. Validasi transaksi sebagai "Valid"
5. Cek email pemesan

## Troubleshooting

### Error: Connection refused

**Penyebab:** Konfigurasi SMTP salah atau firewall memblokir

**Solusi:**
- Pastikan `MAIL_HOST` dan `MAIL_PORT` benar
- Cek firewall/antivirus
- Pastikan internet stabil

### Error: Authentication failed

**Penyebab:** Username/password salah

**Solusi:**
- Untuk Gmail: Gunakan App Password, bukan password biasa
- Pastikan 2-Step Verification aktif di Gmail
- Cek username dan password sudah benar

### Error: SSL certificate problem

**Penyebab:** Masalah SSL certificate

**Solusi:**
Edit file `.env`:
```env
MAIL_ENCRYPTION=tls
```

Atau untuk development, tambahkan di `config/mail.php`:
```php
'stream' => [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ],
],
```

### Email tidak terkirim tapi tidak ada error

**Penyebab:** Email masuk ke spam atau queue

**Solusi:**
1. Cek folder spam di email penerima
2. Pastikan `QUEUE_CONNECTION=sync` di `.env` (untuk testing)
3. Cek log: `storage/logs/laravel.log`

## Konfigurasi Queue (Opsional)

Untuk mengirim email secara asynchronous (tidak menunggu):

1. Edit `.env`:
```env
QUEUE_CONNECTION=database
```

2. Jalankan migration queue:
```bash
php artisan queue:table
php artisan migrate
```

3. Jalankan queue worker:
```bash
php artisan queue:work
```

4. Update `TiketEmail.php`, tambahkan `implements ShouldQueue`:
```php
class TiketEmail extends Mailable implements ShouldQueue
{
    // ...
}
```

## Template Email

Template email terletak di: `resources/views/emails/tiket.blade.php`

Anda dapat mengkustomisasi:
- Warna dan styling
- Logo perusahaan
- Informasi tambahan
- Footer

## Contoh Email yang Dikirim

Email akan berisi:
- ✅ Header dengan judul "Tiket Wisata Anda"
- ✅ Sapaan personal dengan nama pemesan
- ✅ Detail pemesanan (kode, wisata, tanggal, jumlah tiket, total)
- ✅ Catatan penting tentang penggunaan tiket
- ✅ QR Code untuk setiap tiket (dewasa & anak)
- ✅ Informasi kontak wisata
- ✅ Footer dengan ucapan selamat

## Monitoring Email

### Cek Log Email

```bash
tail -f storage/logs/laravel.log
```

### Cek Email Terkirim (Jika pakai Mailtrap)

1. Login ke Mailtrap
2. Buka inbox
3. Lihat email yang masuk

### Cek Email Terkirim (Jika pakai Gmail)

1. Login ke Gmail
2. Buka "Sent" folder
3. Lihat email yang terkirim

## Tips Production

1. **Gunakan Queue** untuk performa lebih baik
2. **Gunakan Service Email** seperti SendGrid/Mailgun untuk reliability
3. **Setup SPF & DKIM** untuk menghindari spam
4. **Monitor Email Bounce** untuk mengetahui email yang gagal
5. **Backup Email Template** sebelum mengubah

## Disable Email (Untuk Development)

Jika tidak ingin mengirim email saat development:

Edit `.env`:
```env
MAIL_MAILER=log
```

Email akan disimpan di `storage/logs/laravel.log` tanpa dikirim sungguhan.

## Support

Jika ada masalah dengan konfigurasi email:
1. Cek log: `storage/logs/laravel.log`
2. Test dengan Mailtrap terlebih dahulu
3. Pastikan kredensial email benar
4. Cek dokumentasi provider email yang digunakan

---

**Selamat! Email tiket sudah dikonfigurasi dan siap digunakan! 📧**
