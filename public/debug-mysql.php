<?php

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Debug MySQL connection specifically
header('Content-Type: application/json');

try {
    // Get environment variables
$host = config('database.connections.mysql.host');
$port = config('database.connections.mysql.port');
$database = config('database.connections.mysql.database');
$username = config('database.connections.mysql.username');
$password = config('database.connections.mysql.password');
    
    $response = [
        'timestamp' => date('Y-m-d H:i:s'),
        'connection_params' => [
            'host' => $host,
            'port' => $port,
            'database' => $database,
            'username' => $username,
            'password' => $password ? 'SET (length: ' . strlen($password) . ')' : 'NOT_SET',
        ],
        'environment_check' => [
            'MYSQLHOST' => env('MYSQLHOST') ?: 'NOT_SET',
            'MYSQLPORT' => env('MYSQLPORT') ?: 'NOT_SET',
            'MYSQLDATABASE' => env('MYSQLDATABASE') ?: 'NOT_SET',
            'MYSQLUSER' => env('MYSQLUSER') ?: 'NOT_SET',
            'MYSQLPASSWORD' => env('MYSQLPASSWORD') ? 'SET' : 'NOT_SET',
            'MYSQL_URL' => env('MYSQL_URL') ?: 'NOT_SET',
            'DATABASE_URL' => env('DATABASE_URL') ?: 'NOT_SET',
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
    } catch (Exception $e) {
        $response['laravel_mysql'] = 'FAILED';
        $response['laravel_error'] = $e->getMessage();
    }
    
    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        'error' => 'Script failed',
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
}
