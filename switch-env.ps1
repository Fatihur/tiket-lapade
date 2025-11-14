# Script untuk switch environment antara development dan production
# Jalankan dengan: .\switch-env.ps1 dev atau .\switch-env.ps1 prod

param(
    [Parameter(Mandatory=$true)]
    [ValidateSet('dev','prod')]
    [string]$Mode
)

if ($Mode -eq "dev") {
    Write-Host "🔧 Switching to DEVELOPMENT mode..." -ForegroundColor Cyan
    
    # Update .env
    (Get-Content .env) -replace 'APP_ENV=production', 'APP_ENV=local' | Set-Content .env
    (Get-Content .env) -replace 'APP_DEBUG=false', 'APP_DEBUG=true' | Set-Content .env
    
    # Clear caches
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    
    Write-Host "✅ Switched to DEVELOPMENT mode" -ForegroundColor Green
    Write-Host "📝 Run: npm run dev" -ForegroundColor Yellow
    
} elseif ($Mode -eq "prod") {
    Write-Host "🚀 Switching to PRODUCTION mode..." -ForegroundColor Cyan
    
    # Update .env
    (Get-Content .env) -replace 'APP_ENV=local', 'APP_ENV=production' | Set-Content .env
    (Get-Content .env) -replace 'APP_DEBUG=true', 'APP_DEBUG=false' | Set-Content .env
    
    # Clear caches
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    
    # Cache for production
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    Write-Host "✅ Switched to PRODUCTION mode" -ForegroundColor Green
    Write-Host "📝 Make sure you run: npm run build" -ForegroundColor Yellow
}
