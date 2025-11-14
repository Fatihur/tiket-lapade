#!/bin/bash

# Script Deployment untuk Production
# Jalankan dengan: bash deploy.sh

echo "🚀 Starting deployment process..."

# 1. Pull latest code
echo "📥 Pulling latest code from git..."
git pull origin main

# 2. Install/Update Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# 3. Install/Update NPM dependencies
echo "📦 Installing NPM dependencies..."
npm install

# 4. Build assets
echo "🔨 Building assets for production..."
npm run build

# 5. Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# 6. Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 7. Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Storage link (if not exists)
echo "🔗 Creating storage link..."
php artisan storage:link

# 9. Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Deployment completed successfully!"
echo ""
echo "📝 Don't forget to:"
echo "   - Check .env configuration"
echo "   - Test the application"
echo "   - Monitor error logs"
