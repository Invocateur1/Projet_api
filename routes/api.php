<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;

// ==========================================
// ROUTES PUBLIQUES (sans authentification)
// ==========================================
Route::prefix('auth')->middleware('throttle:auth')->group(function () { 
    // Maximum 5 tentatives par minute 
    Route::post('register', [AuthController::class, 'register']); 
    Route::post('login', [AuthController::class, 'login']); 
}); 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ==========================================
// ROUTES PROTÉGÉES (authentification requise)
// ==========================================
Route::middleware('auth:api')->prefix('auth')->group(function () {
    // GET /api/auth/me
    Route::get('me', [AuthController::class, 'me']);

    // POST /api/auth/logout
    Route::post('logout', [AuthController::class, 'logout']);

    // POST /api/auth/refresh
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::apiResource('posts', PostController::class)
    ->middleware('throttle:posts');
