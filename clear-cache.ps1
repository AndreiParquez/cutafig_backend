Write-Host "🚀 Clearing Laravel cache..." -ForegroundColor Green

try {
    # Clear all Laravel caches
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear
    
    Write-Host "✅ Cache cleared successfully!" -ForegroundColor Green
    
    # Test if we can connect to the database
    Write-Host "🔍 Testing database connection..." -ForegroundColor Yellow
    php artisan migrate:status
    
} catch {
    Write-Host "❌ Error occurred: $_" -ForegroundColor Red
}
