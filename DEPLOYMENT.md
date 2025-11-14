# Panduan Deployment ke Production

## Persiapan Sebelum Deploy

### 1. Build Assets (Opsional)
```bash
npm install
npm run build
```

**Catatan:** 
- Landing page menggunakan Tailwind CSS CDN, jadi tidak perlu build
- Build hanya diperlukan untuk admin dashboard
- Jika tidak build, admin dashboard akan tetap berfungsi tapi mungkin ada warning di console

Ini akan menghasilkan file di folder `public/build/` yang siap untuk production.

### 2. Update File .env untuk Production

```env
APP_NAME="Tiket Wisata Online"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Production
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Mail Configuration (Gunakan SMTP yang valid)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### 3. Optimize Laravel untuk Production

```bash
# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Generate cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 4. Set Permission yang Benar

```bash
# Linux/Unix
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Atau
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## Deployment ke Shared Hosting (cPanel)

### 1. Upload Files
- Upload semua file kecuali folder `node_modules` dan `.git`
- Pastikan folder `public/build` sudah ada (hasil npm run build)

### 2. Setup Database
- Buat database MySQL di cPanel
- Import database atau jalankan migration:
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 3. Setup .htaccess
Pastikan file `public/.htaccess` ada dan berisi:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 4. Point Domain ke Folder Public
- Di cPanel, set document root ke folder `public`
- Atau buat symlink dari public_html ke folder public

### 5. Storage Link
```bash
php artisan storage:link
```

## Deployment ke VPS (Ubuntu/Debian)

### 1. Install Dependencies
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2+
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y

# Install Nginx
sudo apt install nginx -y

# Install MySQL
sudo apt install mysql-server -y
```

### 2. Clone & Setup Project
```bash
cd /var/www
git clone <your-repo-url> tiket-wisata
cd tiket-wisata

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Setup permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Setup .env
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Configure Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/tiket-wisata/public;

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

### 4. Enable Site & Restart Nginx
```bash
sudo ln -s /etc/nginx/sites-available/tiket-wisata /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 5. Setup SSL (Optional but Recommended)
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com
```

## Troubleshooting

### Error: Vite manifest not found
**Solusi:**
```bash
npm run build
php artisan config:clear
```

### Error: Permission denied
**Solusi:**
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Error: 500 Internal Server Error
**Solusi:**
1. Check error log: `tail -f storage/logs/laravel.log`
2. Set `APP_DEBUG=true` sementara untuk melihat error
3. Pastikan `.env` sudah benar
4. Clear cache: `php artisan config:clear`

### Error: Assets tidak load (CSS/JS)
**Solusi:**
1. Pastikan sudah run `npm run build`
2. Check folder `public/build` ada dan berisi file
3. Clear browser cache
4. Check APP_URL di .env sudah benar

### Error: QR Code tidak generate
**Solusi:**
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:clear
sudo chmod -R 775 storage/app/public
```

### Error: Email tidak terkirim
**Solusi:**
1. Check konfigurasi MAIL di .env
2. Untuk Gmail, gunakan App Password bukan password biasa
3. Test dengan: `php artisan tinker` lalu `Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });`

## Checklist Deployment

- [ ] Build assets dengan `npm run build`
- [ ] Update .env untuk production (APP_ENV=production, APP_DEBUG=false)
- [ ] Set database credentials yang benar
- [ ] Run migrations dan seeders
- [ ] Set permissions untuk storage dan bootstrap/cache
- [ ] Run `php artisan storage:link`
- [ ] Cache config, routes, dan views
- [ ] Test semua fitur utama
- [ ] Setup backup database otomatis
- [ ] Setup SSL certificate
- [ ] Monitor error logs

## Maintenance Mode

Untuk maintenance:
```bash
php artisan down --secret="maintenance-token"
```

Akses dengan: `https://yourdomain.com/maintenance-token`

Untuk kembali online:
```bash
php artisan up
```

## Backup

### Backup Database
```bash
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
```

### Backup Files
```bash
tar -czf backup_files_$(date +%Y%m%d).tar.gz /var/www/tiket-wisata
```

## Update Aplikasi

```bash
# Pull latest code
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear & cache
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

**Catatan Penting:**
- Jangan pernah commit file `.env` ke git
- Selalu backup database sebelum update
- Test di staging environment dulu sebelum production
- Monitor logs secara berkala
- Setup automated backups
