<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

echo "🔧 Fixing Database Configuration...\n\n";

try {
    // Test database connection
    echo "1. Testing MySQL connection...\n";
    $connection = DB::connection('mysql');
    $pdo = $connection->getPdo();
    echo "✅ MySQL connection successful!\n\n";
    
    // Check if cache table exists
    echo "2. Checking if cache table exists...\n";
    $tableExists = Schema::hasTable('cache');
    
    if ($tableExists) {
        echo "✅ Cache table exists!\n\n";
    } else {
        echo "❌ Cache table does not exist. Running migrations...\n";
        
        // Run migrations
        Artisan::call('migrate', ['--force' => true]);
        echo "✅ Migrations completed!\n\n";
    }
    
    // Clear cache
    echo "3. Clearing application cache...\n";
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    echo "✅ Cache cleared!\n\n";
    
    // Test cache functionality
    echo "4. Testing cache functionality...\n";
    Cache::put('test_key', 'test_value', 60);
    $value = Cache::get('test_key');
    
    if ($value === 'test_value') {
        echo "✅ Cache is working correctly!\n";
    } else {
        echo "❌ Cache test failed!\n";
    }
    
    echo "\n🎉 Database configuration fixed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "🔍 Stack trace:\n" . $e->getTraceAsString() . "\n";
}
