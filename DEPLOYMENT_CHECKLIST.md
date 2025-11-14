# Checklist Deployment ke Production

## Pre-Deployment

### 1. Environment Configuration
- [ ] Copy `.env.example` ke `.env`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate `APP_KEY`: `php artisan key:generate`
- [ ] Set `APP_URL` sesuai domain production

### 2. Database Configuration
- [ ] Set database credentials di `.env`
- [ ] Test koneksi database
- [ ] Backup database jika ada data penting

### 3. Email Configuration
- [ ] Set MAIL_* credentials di `.env`
- [ ] Test kirim email: `php test-email.php`
- [ ] Pastikan email terkirim dengan benar

### 4. File Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 5. Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

---

## Deployment Steps

### 1. Upload Files
Upload semua file ke server kecuali:
- `/node_modules`
- `/vendor` (akan di-install di server)
- `.env` (buat baru di server)
- `/storage` (buat folder kosong)

### 2. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dengan konfigurasi production.

### 4. Database Migration
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 5. Storage Link
```bash
php artisan storage:link
```

### 6. Cache Optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. File Permissions (lagi)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

---

## Web Server Configuration

### Apache (.htaccess)
File `.htaccess` sudah ada di folder `public/`.

Pastikan `mod_rewrite` enabled:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Virtual Host configuration:
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/tiket-lapade/public

    <Directory /path/to/tiket-lapade/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/tiket-lapade/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## SSL Certificate (HTTPS)

### Using Let's Encrypt (Certbot)
```bash
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d yourdomain.com
```

Atau untuk Nginx:
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

Auto-renewal:
```bash
sudo certbot renew --dry-run
```

---

## Post-Deployment Testing

### 1. Test Landing Page
- [ ] Buka https://yourdomain.com
- [ ] Cek tampilan homepage
- [ ] Cek detail wisata
- [ ] Cek form pemesanan

### 2. Test Login
- [ ] Login sebagai Admin
- [ ] Login sebagai Petugas
- [ ] Login sebagai Bendahara
- [ ] Login sebagai Owner

### 3. Test Upload
- [ ] Upload bukti transfer (pemesanan)
- [ ] Upload foto galeri wisata

### 4. Test Email
- [ ] Validasi transaksi
- [ ] Cek email terkirim
- [ ] Cek PDF attachment
- [ ] Cek QR Code di PDF

### 5. Test QR Code
- [ ] Scan QR Code dari tiket
- [ ] Validasi tiket berhasil

---

## Monitoring & Maintenance

### 1. Log Files
```bash
tail -f storage/logs/laravel.log
```

### 2. Clear Cache (jika ada update)
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Lalu cache lagi:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Database Backup
Setup cron job untuk backup otomatis:
```bash
0 2 * * * mysqldump -u username -p'password' database_name > /backup/db_$(date +\%Y\%m\%d).sql
```

### 4. Storage Cleanup
Bersihkan file lama secara berkala:
```bash
# Hapus bukti transfer > 30 hari
find storage/app/public/bukti_transfer -type f -mtime +30 -delete
```

---

## Security Checklist

- [ ] `APP_DEBUG=false` di production
- [ ] `APP_ENV=production`
- [ ] HTTPS enabled (SSL certificate)
- [ ] Strong database password
- [ ] Firewall configured
- [ ] Disable directory listing
- [ ] Hide Laravel version
- [ ] Regular security updates
- [ ] Backup strategy in place

---

## Troubleshooting

### Error 500
```bash
# Cek log
tail -f storage/logs/laravel.log

# Cek permission
chmod -R 775 storage bootstrap/cache
```

### Error 404 (routes not found)
```bash
# Clear cache
php artisan route:clear
php artisan config:clear

# Cache lagi
php artisan route:cache
php artisan config:cache
```

### Email tidak terkirim
- Cek konfigurasi MAIL_* di `.env`
- Cek firewall port 587/465
- Cek log: `storage/logs/laravel.log`

### Upload file gagal
```bash
# Cek permission
chmod -R 775 storage/app/public
chown -R www-data:www-data storage
```

---

## Performance Optimization

### 1. OPcache (PHP)
Edit `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

### 2. Database Indexing
Sudah ada di migration, pastikan index terpakai.

### 3. CDN untuk Assets
Upload assets (CSS, JS, images) ke CDN untuk loading lebih cepat.

### 4. Queue untuk Email
Jika email banyak, gunakan queue:
```bash
php artisan queue:work --daemon
```

Setup supervisor untuk queue worker.

---

## Rollback Plan

Jika ada masalah setelah deployment:

1. Restore database backup
```bash
mysql -u username -p database_name < backup.sql
```

2. Restore file backup
```bash
cp -r backup/* /path/to/tiket-lapade/
```

3. Clear all cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## Support & Documentation

Dokumentasi lengkap tersedia di:
- `README.md` - Overview
- `PANDUAN_INSTALASI.md` - Instalasi
- `PANDUAN_PENGGUNAAN.md` - Cara pakai
- `TEST_APLIKASI.md` - Testing
- `DAFTAR_ENDPOINT.md` - API endpoints

Selamat deployment! 🚀
