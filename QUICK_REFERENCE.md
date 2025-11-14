# Quick Reference - Tiket Wisata Online

## 🚀 Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

## 👤 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@wisata.com | password |
| Petugas | petugas@wisata.com | password |
| Bendahara | bendahara@wisata.com | password |
| Owner | owner@wisata.com | password |

## 📍 Important URLs

- Homepage: http://localhost:8000
- Login: http://localhost:8000/login
- Admin: http://localhost:8000/admin/dashboard
- Petugas: http://localhost:8000/petugas/dashboard

## 🛠️ Common Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reset database
php artisan migrate:fresh --seed

# Test email
php test-email.php

# Test QR Code
php test-qr.php

# Test PDF
php test-pdf.php
```

## 📁 Important Folders

```
app/
├── Http/Controllers/     # Controllers
├── Models/              # Models
├── Mail/                # Email classes
└── Http/Middleware/     # Middleware

resources/views/
├── landing/             # Public pages
├── admin/               # Admin panel
├── petugas/             # Petugas panel
├── bendahara/           # Bendahara panel
├── owner/               # Owner panel
├── emails/              # Email templates
└── pdf/                 # PDF templates

database/
├── migrations/          # Database migrations
└── seeders/             # Database seeders

storage/app/public/
├── bukti_transfer/      # Upload bukti transfer
└── galeri_wisata/       # Upload galeri
```

## 🔧 Troubleshooting

**Error: Storage link not found**
```bash
php artisan storage:link
```

**Error: Permission denied**
```bash
chmod -R 775 storage bootstrap/cache
```

**Error: Email tidak terkirim**
- Cek konfigurasi MAIL_* di .env
- Gunakan App Password untuk Gmail

**Error: QR Code tidak muncul**
```bash
composer require simplesoftwareio/simple-qrcode
```

## 📚 Documentation

- README.md - Overview
- PANDUAN_INSTALASI.md - Installation guide
- PANDUAN_PENGGUNAAN.md - User guide
- TEST_APLIKASI.md - Testing checklist
- DEPLOYMENT_CHECKLIST.md - Deployment guide
- STATUS_PROYEK.md - Project status

## 🎯 Key Features

✅ Role-based authentication
✅ Online ticket booking
✅ Payment validation
✅ Email with PDF ticket
✅ QR Code generation
✅ QR Code scanning
✅ Sales reports
✅ User management

## 📞 Support

Baca dokumentasi lengkap di folder root project.
