# Troubleshooting Guide

## Error: Vite manifest not found / ERR_BLOCKED_BY_CLIENT

### Gejala:
```
GET http://[::1]:5173/resources/css/app.css net::ERR_BLOCKED_BY_CLIENT
GET http://[::1]:5173/@vite/client net::ERR_BLOCKED_BY_CLIENT
GET http://[::1]:5173/resources/js/app.js net::ERR_BLOCKED_BY_CLIENT
```

### Penyebab:
Laravel masih mencoba menggunakan Vite dev server padahal seharusnya menggunakan build assets.

### Catatan Penting:
**Landing page sudah tidak menggunakan Vite!** Landing page sekarang menggunakan Tailwind CSS CDN, jadi error ini seharusnya hanya muncul di admin dashboard.

### Solusi:

#### 1. Pastikan APP_ENV sudah production
Edit file `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

#### 2. Build assets
```bash
npm run build
```

#### 3. Clear semua cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

#### 4. Cache untuk production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 5. Restart server
```bash
# Stop server (Ctrl+C)
php artisan serve
```

### Quick Fix (Windows):
```powershell
.\switch-env.ps1 prod
npm run build
```

### Quick Fix (Linux/Mac):
```bash
bash switch-env.sh prod
npm run build
```

---

## Error: Permission Denied

### Gejala:
```
The stream or file "storage/logs/laravel.log" could not be opened
```

### Solusi:

#### Windows:
```powershell
icacls storage /grant Everyone:F /t
icacls bootstrap/cache /grant Everyone:F /t
```

#### Linux/Mac:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## Error: Class not found

### Gejala:
```
Class 'App\Models\Something' not found
```

### Solusi:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

---

## Error: Route not found

### Gejala:
```
404 | Not Found
```

### Solusi:
```bash
php artisan route:clear
php artisan route:cache
php artisan route:list  # Cek apakah route ada
```

---

## Error: SQLSTATE Connection refused

### Gejala:
```
SQLSTATE[HY000] [2002] Connection refused
```

### Solusi:

#### Cek database configuration di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### Pastikan MySQL running:
```bash
# Windows
net start MySQL80

# Linux
sudo systemctl start mysql

# Mac
brew services start mysql
```

#### Test connection:
```bash
php artisan tinker
DB::connection()->getPdo();
```

---

## Error: QR Code tidak generate

### Gejala:
QR Code tidak muncul atau error saat generate tiket

### Solusi:

#### 1. Install package:
```bash
composer require simplesoftwareio/simple-qrcode
```

#### 2. Clear cache:
```bash
php artisan config:clear
composer dump-autoload
```

#### 3. Check GD extension:
```bash
php -m | grep -i gd
```

Jika tidak ada, install:
```bash
# Ubuntu/Debian
sudo apt install php8.2-gd

# Windows (uncomment di php.ini)
extension=gd
```

---

## Error: Email tidak terkirim

### Gejala:
Email tiket tidak sampai ke customer

### Solusi:

#### 1. Cek konfigurasi MAIL di `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Tiket Wisata Online"
```

#### 2. Untuk Gmail, gunakan App Password:
1. Buka https://myaccount.google.com/security
2. Enable 2-Step Verification
3. Generate App Password
4. Gunakan App Password di MAIL_PASSWORD

#### 3. Test email:
```bash
php artisan tinker
```
```php
Mail::raw('Test email', function($m) {
    $m->to('test@example.com')->subject('Test');
});
```

#### 4. Check logs:
```bash
tail -f storage/logs/laravel.log
```

---

## Error: 500 Internal Server Error

### Gejala:
Halaman menampilkan error 500

### Solusi:

#### 1. Enable debug mode sementara:
```env
APP_DEBUG=true
```

#### 2. Check error logs:
```bash
tail -f storage/logs/laravel.log
```

#### 3. Common fixes:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
composer dump-autoload
```

#### 4. Check permissions:
```bash
chmod -R 775 storage bootstrap/cache
```

---

## Error: Mixed Content (HTTP/HTTPS)

### Gejala:
Assets tidak load karena mixed content warning

### Solusi:

#### Update APP_URL di `.env`:
```env
APP_URL=https://yourdomain.com
```

#### Force HTTPS di `AppServiceProvider.php`:
```php
public function boot()
{
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
```

---

## Development vs Production

### Switch ke Development:
```bash
# Windows
.\switch-env.ps1 dev
npm run dev

# Linux/Mac
bash switch-env.sh dev
npm run dev
```

### Switch ke Production:
```bash
# Windows
.\switch-env.ps1 prod
npm run build

# Linux/Mac
bash switch-env.sh prod
npm run build
```

---

## Clear Everything (Nuclear Option)

Jika semua cara di atas tidak berhasil:

```bash
# Clear all caches
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Rebuild autoload
composer dump-autoload

# Rebuild assets
npm run build

# Restart server
# Stop (Ctrl+C) then start again
php artisan serve
```

---

## Useful Commands

### Check Laravel version:
```bash
php artisan --version
```

### Check PHP version:
```bash
php -v
```

### Check installed packages:
```bash
composer show
```

### Check routes:
```bash
php artisan route:list
```

### Check config:
```bash
php artisan config:show
```

### Check database connection:
```bash
php artisan tinker
DB::connection()->getPdo();
```

---

## Getting Help

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check web server logs (Apache/Nginx)
3. Check PHP error logs
4. Enable debug mode temporarily: `APP_DEBUG=true`
5. Search error message on Google/Stack Overflow
6. Check Laravel documentation: https://laravel.com/docs
