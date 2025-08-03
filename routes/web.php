<?php

use Illuminate\Support\Facades\Route;

// Only keep the welcome page for basic testing
Route::get('/', function () {
    return response()->json([
        'message' => 'Cutafig Backend API',
        'version' => '1.0',
        'docs' => 'Use /api endpoints for API access'
    ]);
});