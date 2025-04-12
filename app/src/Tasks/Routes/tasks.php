<?php

use Illuminate\Support\Facades\Route;
use Src\Tasks\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('buildings/{building}/tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{task}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put('/{task}', [TaskController::class, 'update']);
    Route::delete('/{task}', [TaskController::class, 'destroy']);

    Route::post('/{task}/start', [TaskController::class, 'startTask']);
    Route::post('/{task}/finish', [TaskController::class, 'finishTask']);
    Route::post('/{task}/reject', [TaskController::class, 'rejectTask']);
});
