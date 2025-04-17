<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Project Routes - Requires Authentication
Route::middleware('auth:api')->group(function () {
    Route::apiResource('projects', ProjectController::class);  // Project CRUD
    Route::get('projects/{project}/report', [ReportController::class, 'projectReport']);  // Project Report
});

// Logout Route - Requires Authentication
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
