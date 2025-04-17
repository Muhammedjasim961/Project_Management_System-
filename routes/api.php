<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RemarkController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskRemarkController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', action: [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Projects routes
    Route::apiResource('projects', ProjectController::class);

    Route::get('projects/{project}/report', [ReportController::class, 'projectReport']);

    Route::prefix('projects/{project}')->group(function () {
        Route::get('tasks', [TaskController::class, 'index']);
        Route::post('tasks', [TaskController::class, 'store']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('projects/{project}/tasks', [TaskController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::get('/projects/{project}/tasks', [TaskController::class, 'index']);
    Route::get('/projects', [ProjectController::class, 'index']);
});
Route::middleware('auth:api')->post('/projects/{projectId}/tasks', [TaskController::class, 'store']);
Route::put('/projects/{projectId}/tasks/{taskId}/status', [TaskController::class, 'updateStatus']);
Route::post('/projects/{projectId}/tasks/{taskId}/remarks', [TaskController::class, 'addRemark']);

Route::post('/projects/{project}/tasks/{task}/remarks', [RemarkController::class, 'storeRemark']);
Route::get('projects/{project}/tasks/{task}/remarks', [TaskController::class, 'getRemarks']);
Route::put('projects/{project_id}/tasks/{task_id}/status', [TaskController::class, 'updateStatus']);
Route::middleware('auth:api')->get('/projects/{project}/report', [ProjectController::class, 'report']);

Route::middleware('auth:api')->group(function () {
    Route::delete('projects/{project}/tasks/{task}/remarks/{remark}', [TaskRemarkController::class, 'destroy']);
});
Route::middleware('auth:api')->get('/projects/{project}/tasks', [TaskController::class, 'index']);
Route::delete('/projects/{projectId}/tasks/{taskId}/remarks/{remarkId}', [TaskRemarkController::class, 'destroy']);
