<?php

use Illuminate\Support\Facades\Route;
use Src\Comments\Http\Controllers\CommentController;

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

Route::prefix('buildings/{building}/tasks/{task}/comments')->group(function () {
    Route::get('/', [CommentController::class, 'index']);
    Route::get('/{comment}', [CommentController::class, 'show']);
    Route::post('/', [CommentController::class, 'store']);
    Route::delete('/{comment}', [CommentController::class, 'destroy']);
});
