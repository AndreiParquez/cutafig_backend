<?php

use Illuminate\Support\Facades\Route;

// Health check route
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'environment' => app()->environment(),
    ]);
});

// Only keep the welcome page for basic testing
Route::get('/', function () {
    return response()->json([
        'message' => 'Cutafig Backend API',
        'version' => '1.0',
        'docs' => 'Use /api endpoints for API access',
        'health' => url('/health'),
    ]);
});