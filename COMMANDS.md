# Quick Command Reference

## Development

### Start Development Server
```bash
php artisan serve
```

### Watch Assets (Development)
```bash
npm run dev
```

### Clear All Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## Database

### Run Migrations
```bash
php artisan migrate
```

### Run Seeders
```bash
php artisan db:seed
```

### Fresh Migration (Reset & Seed)
```bash
php artisan migrate:fresh --seed
```

### Rollback Migration
```bash
php artisan migrate:rollback
```

## Production

### Build Assets for Production
```bash
npm run build
```

### Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### Clear Production Caches
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## Storage

### Create Storage Link
```bash
php artisan storage:link
```

### Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

## Maintenance

### Enable Maintenance Mode
```bash
php artisan down
```

### Enable with Secret Token
```bash
php artisan down --secret="maintenance-token"
# Access: https://yourdomain.com/maintenance-token
```

### Disable Maintenance Mode
```bash
php artisan up
```

## Testing

### Run Tests
```bash
php artisan test
```

### Run Specific Test
```bash
php artisan test --filter=TestName
```

## Queue (If Using)

### Run Queue Worker
```bash
php artisan queue:work
```

### Run Queue in Background
```bash
php artisan queue:work --daemon
```

## Tinker (Laravel REPL)

### Open Tinker
```bash
php artisan tinker
```

### Test Email in Tinker
```php
Mail::raw('Test email', function($m) {
    $m->to('test@example.com')->subject('Test');
});
```

## Git

### Initial Commit
```bash
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin <repository-url>
git push -u origin main
```

### Update & Deploy
```bash
git add .
git commit -m "Update message"
git push origin main
```

## Composer

### Install Dependencies
```bash
composer install
```

### Update Dependencies
```bash
composer update
```

### Dump Autoload
```bash
composer dump-autoload
```

## NPM

### Install Dependencies
```bash
npm install
```

### Update Dependencies
```bash
npm update
```

### Build for Production
```bash
npm run build
```

### Development Watch
```bash
npm run dev
```

## Troubleshooting

### Fix Permission Issues
```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Regenerate App Key
```bash
php artisan key:generate
```

### Clear Everything
```bash
php artisan optimize:clear
composer dump-autoload
```

### Check Routes
```bash
php artisan route:list
```

### Check Config
```bash
php artisan config:show
```

## Backup

### Backup Database (MySQL)
```bash
mysqldump -u username -p database_name > backup.sql
```

### Restore Database
```bash
mysql -u username -p database_name < backup.sql
```

### Backup Files
```bash
tar -czf backup_$(date +%Y%m%d).tar.gz /path/to/project
```

## Logs

### View Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

### Clear Logs
```bash
echo "" > storage/logs/laravel.log
```

## Quick Fixes

### "Vite manifest not found"
```bash
npm run build
php artisan config:clear
```

### "Permission denied"
```bash
chmod -R 775 storage bootstrap/cache
```

### "Class not found"
```bash
composer dump-autoload
php artisan config:clear
```

### "Route not found"
```bash
php artisan route:clear
php artisan route:cache
```
