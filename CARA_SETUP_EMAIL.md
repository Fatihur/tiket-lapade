                           # Cara Setup Email - Quick Guide

## 🚀 Setup Cepat (5 Menit)

### Opsi 1: Menggunakan Gmail (Recommended untuk Production)

1. **Buka Google Account**
   - Kunjungi: https://myaccount.google.com/
   - Login dengan akun Gmail Anda

2. **Aktifkan 2-Step Verification**
   - Klik **Security** (Keamanan)
   - Scroll ke bawah, klik **2-Step Verification**
   - Ikuti langkah-langkah untuk mengaktifkan

3. **Generate App Password**
   - Masih di halaman Security
   - Scroll ke bawah, klik **App passwords**
   - Pilih app: **Mail**
   - Pilih device: **Other** (ketik: Laravel)
   - Klik **Generate**
   - **COPY** password 16 digit yang muncul (contoh: `abcd efgh ijkl mnop`)

4. **Edit File `.env`**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=email-anda@gmail.com
   MAIL_PASSWORD=abcdefghijklmnop
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=email-anda@gmail.com
   MAIL_FROM_NAME="Tiket Wisata Online"
   ```

5. **Clear Cache**
   ```bash
   php artisan config:clear
   ```

6. **Test Email**
   ```bash
   php artisan tinker
   ```
   
   Ketik:
   ```php
   Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });
   ```
   
   Tekan Enter. Jika tidak ada error, email berhasil dikonfigurasi! ✅

---

### Opsi 2: Menggunakan Mailtrap (Untuk Testing/Development)

1. **Daftar Mailtrap**
   - Kunjungi: https://mailtrap.io/
   - Daftar gratis (bisa pakai Google/GitHub)

2. **Buat Inbox**
   - Klik **Add Inbox**
   - Beri nama: "Laravel Testing"

3. **Copy Kredensial**
   - Klik inbox yang baru dibuat
   - Pilih tab **SMTP Settings**
   - Pilih **Laravel 9+**
   - Copy kredensial yang muncul

4. **Edit File `.env`**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your-mailtrap-username
   MAIL_PASSWORD=your-mailtrap-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=test@example.com
   MAIL_FROM_NAME="Tiket Wisata Online"
   ```

5. **Clear Cache & Test**
   ```bash
   php artisan config:clear
   ```

6. **Cek Email di Mailtrap**
   - Setelah validasi transaksi
   - Buka Mailtrap inbox
   - Email akan muncul di sana (tidak dikirim ke email sungguhan)

---

### Opsi 3: Log Only (Untuk Development Tanpa Email)

Jika tidak ingin setup email dulu, gunakan mode log:

```env
MAIL_MAILER=log
```

Email akan disimpan di `storage/logs/laravel.log` tanpa dikirim sungguhan.

---

## 📧 Cara Kerja Email Tiket

1. **Pengunjung** melakukan pemesanan dan upload bukti transfer
2. **Admin** login dan validasi transaksi sebagai "Valid"
3. **Sistem** otomatis:
   - Generate QR Code untuk setiap tiket
   - Kirim email ke pengunjung
4. **Pengunjung** menerima email berisi:
   - Detail pemesanan
   - QR Code tiket (bisa di-scan di pintu masuk)
   - Informasi penting

---

## ✅ Checklist Setup Email

- [ ] Pilih provider email (Gmail/Mailtrap/dll)
- [ ] Dapatkan kredensial (username & password)
- [ ] Edit file `.env` dengan kredensial
- [ ] Jalankan `php artisan config:clear`
- [ ] Test email dengan tinker
- [ ] Test dengan pemesanan real
- [ ] Cek email masuk (atau Mailtrap inbox)

---

## 🐛 Troubleshooting Cepat

### Email tidak terkirim?

1. **Cek log error:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Cek konfigurasi:**
   ```bash
   php artisan config:show mail
   ```

3. **Clear cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Gmail: Authentication failed?

- ✅ Pastikan menggunakan **App Password**, bukan password Gmail biasa
- ✅ Pastikan **2-Step Verification** sudah aktif
- ✅ Cek username dan password tidak ada spasi

### Email masuk spam?

- Untuk production, gunakan domain sendiri
- Setup SPF dan DKIM records
- Gunakan service email profesional (SendGrid/Mailgun)

---

## 📚 Dokumentasi Lengkap

Lihat file **KONFIGURASI_EMAIL.md** untuk:
- Konfigurasi provider email lainnya
- Setup queue untuk performa
- Customisasi template email
- Tips production
- Dan lainnya

---

## 🎉 Selesai!

Setelah setup email, sistem akan otomatis mengirim tiket ke pengunjung setelah admin validasi pembayaran.

**Happy Coding! 🚀**
