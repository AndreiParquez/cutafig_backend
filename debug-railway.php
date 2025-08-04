<?php
// Debug script to check environment variables on Railway

echo "=== Railway Environment Debug ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Current working directory: " . getcwd() . "\n";
echo "\n=== Environment Variables ===\n";

$envVars = [
    'PORT',
    'APP_ENV',
    'APP_DEBUG',
    'APP_KEY',
    'DB_CONNECTION',
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'MYSQLHOST',
    'MYSQLPORT',
    'MYSQLDATABASE',
    'MYSQLUSER',
];

foreach ($envVars as $var) {
    $value = $_ENV[$var] ?? getenv($var) ?? 'NOT SET';
    if ($var === 'APP_KEY' && $value !== 'NOT SET') {
        $value = 'SET (hidden for security)';
    }
    echo "{$var}: {$value}\n";
}

echo "\n=== All Environment Variables (first 20) ===\n";
$count = 0;
foreach ($_ENV as $key => $value) {
    if ($count++ >= 20) break;
    if (strpos($key, 'KEY') !== false || strpos($key, 'PASSWORD') !== false) {
        $value = 'HIDDEN';
    }
    echo "{$key}: {$value}\n";
}

echo "\n=== Laravel Configuration Test ===\n";
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    echo "Laravel Bootstrap: SUCCESS\n";
    echo "App Environment: " . app()->environment() . "\n";
    echo "Config Cached: " . (app()->configurationIsCached() ? 'YES' : 'NO') . "\n";
    
} catch (Exception $e) {
    echo "Laravel Bootstrap: FAILED - " . $e->getMessage() . "\n";
}

echo "=== End Debug ===\n";
?>
