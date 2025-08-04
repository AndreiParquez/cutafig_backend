<?php

// Simple diagnostic script to check configuration
header('Content-Type: application/json');

echo json_encode([
    'timestamp' => date('Y-m-d H:i:s'),
    'environment' => [
        'APP_ENV' => env('APP_ENV'),
        'DB_CONNECTION' => env('DB_CONNECTION'),
        'DB_HOST' => env('DB_HOST'),
        'DB_DATABASE' => env('DB_DATABASE'),
        'CACHE_STORE' => env('CACHE_STORE'),
        'DB_CACHE_CONNECTION' => env('DB_CACHE_CONNECTION'),
        'DB_CACHE_TABLE' => env('DB_CACHE_TABLE'),
    ],
    'config' => [
        'database.default' => config('database.default'),
        'cache.default' => config('cache.default'),
        'cache.stores.database.connection' => config('cache.stores.database.connection'),
        'cache.stores.database.table' => config('cache.stores.database.table'),
    ],
    'mysql_vars' => [
        'MYSQLHOST' => env('MYSQLHOST', 'NOT_SET'),
        'MYSQLUSER' => env('MYSQLUSER', 'NOT_SET'),
        'MYSQLDATABASE' => env('MYSQLDATABASE', 'NOT_SET'),
    ]
], JSON_PRETTY_PRINT);
