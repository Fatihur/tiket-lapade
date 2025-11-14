#!/bin/bash

# Script untuk switch environment antara development dan production

if [ "$1" == "dev" ]; then
    echo "🔧 Switching to DEVELOPMENT mode..."
    sed -i 's/APP_ENV=production/APP_ENV=local/' .env
    sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' .env
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    echo "✅ Switched to DEVELOPMENT mode"
    echo "📝 Run: npm run dev"
    
elif [ "$1" == "prod" ]; then
    echo "🚀 Switching to PRODUCTION mode..."
    sed -i 's/APP_ENV=local/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo "✅ Switched to PRODUCTION mode"
    echo "📝 Make sure you run: npm run build"
    
else
    echo "Usage: bash switch-env.sh [dev|prod]"
    echo "  dev  - Switch to development mode"
    echo "  prod - Switch to production mode"
fi
