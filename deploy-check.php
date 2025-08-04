<?php
// Simple deployment check script for Railway

echo "=== Cutafig Backend Deployment Check ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Environment: " . ($_ENV['APP_ENV'] ?? 'not set') . "\n";
echo "Port: " . ($_ENV['PORT'] ?? 'not set') . "\n";
echo "APP_KEY: " . (empty($_ENV['APP_KEY']) ? 'not set' : 'set') . "\n";

// Check if .env file exists
if (file_exists('.env')) {
    echo ".env file: exists\n";
} else {
    echo ".env file: missing\n";
}

// Test database connection
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "Database: connected\n";
} catch (Exception $e) {
    echo "Database: failed - " . $e->getMessage() . "\n";
}

echo "=== End Check ===\n";
?>
