<?php

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Debug MySQL connection specifically
header('Content-Type: application/json');

try {
    // Get environment variables - check both Railway service syntax and direct variables
    $host = env('DB_HOST', env('MYSQLHOST'));
    $port = env('DB_PORT', env('MYSQLPORT', 3306));
    $database = env('DB_DATABASE', env('MYSQLDATABASE'));
    $username = env('DB_USERNAME', env('MYSQLUSER'));
    $password = env('DB_PASSWORD', env('MYSQLPASSWORD'));
    
    $response = [
        'timestamp' => date('Y-m-d H:i:s'),
        'connection_params' => [
            'host' => $host,
            'port' => $port,
            'database' => $database,
            'username' => $username,
            'password' => $password ? 'SET (length: ' . strlen($password) . ')' : 'NOT_SET',
        ],
        'railway_variables' => [
            'DB_HOST' => env('DB_HOST') ?: 'NOT_SET',
            'DB_PORT' => env('DB_PORT') ?: 'NOT_SET',
            'DB_DATABASE' => env('DB_DATABASE') ?: 'NOT_SET',
            'DB_USERNAME' => env('DB_USERNAME') ?: 'NOT_SET',
            'DB_PASSWORD' => env('DB_PASSWORD') ? 'SET' : 'NOT_SET',
            'DATABASE_URL' => env('DATABASE_URL') ?: 'NOT_SET',
        ],
        'mysql_service_variables' => [
            'MYSQLHOST' => env('MYSQLHOST') ?: 'NOT_SET',
            'MYSQLPORT' => env('MYSQLPORT') ?: 'NOT_SET',
            'MYSQLDATABASE' => env('MYSQLDATABASE') ?: 'NOT_SET',
            'MYSQLUSER' => env('MYSQLUSER') ?: 'NOT_SET',
            'MYSQLPASSWORD' => env('MYSQLPASSWORD') ? 'SET' : 'NOT_SET',
            'MYSQL_URL' => env('MYSQL_URL') ?: 'NOT_SET',
        ],
        'debug_info' => [
            'using_host' => $host ?: 'NULL',
            'using_port' => $port ?: 'NULL',
            'using_database' => $database ?: 'NULL',
            'using_username' => $username ?: 'NULL',
            'has_password' => !empty($password),
        ]
    ];
    
    // Try to connect to MySQL
    if ($host && $port && $database && $username) {
        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$database}";
            $pdo = new PDO($dsn, $username, $password);
            $response['mysql_connection'] = 'SUCCESS';
            $response['mysql_version'] = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        } catch (PDOException $e) {
            $response['mysql_connection'] = 'FAILED';
            $response['mysql_error'] = $e->getMessage();
        }
    } else {
        $response['mysql_connection'] = 'SKIPPED - Missing required parameters';
    }
    
    // Test Laravel database connection
    try {
        $connection = DB::connection('mysql');
        $connection->getPdo();
        $response['laravel_mysql'] = 'SUCCESS';
        
        // Test a simple query
        $result = $connection->select('SELECT VERSION() as version, DATABASE() as current_db');
        $response['mysql_info'] = $result[0] ?? null;
        
    } catch (Exception $e) {
        $response['laravel_mysql'] = 'FAILED';
        $response['laravel_error'] = $e->getMessage();
    }
    
    // Check if the Railway variables are being resolved
    $response['raw_env_check'] = [
        'DB_HOST_raw' => $_ENV['DB_HOST'] ?? 'NOT_SET_IN_ENV',
        'DATABASE_URL_raw' => $_ENV['DATABASE_URL'] ?? 'NOT_SET_IN_ENV',
        'all_mysql_vars' => array_filter($_ENV, function($key) {
            return strpos(strtoupper($key), 'MYSQL') !== false;
        }, ARRAY_FILTER_USE_KEY),
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        'error' => 'Script failed',
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
}
