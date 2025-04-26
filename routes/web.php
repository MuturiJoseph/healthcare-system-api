<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes (require authentication, doctor role, and throttling)
    Route::middleware(['auth:sanctum', 'doctor', 'throttle:60,1'])->group(function () {
        Route::post('/programs', [ProgramController::class, 'store']);
        Route::post('/clients', [ClientController::class, 'store']);
        Route::post('/clients/{client}/enroll', [ClientController::class, 'enroll']);
        Route::get('/clients/search', [ClientController::class, 'search']);
        Route::get('/clients/{client}', [ClientController::class, 'show']);
    });
});