<?php

use Illuminate\Support\Facades\Route;
use Src\Buildings\Http\Controllers\BuildingController;

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
Route::middleware('auth:api')->prefix('buildings')->group(function () {
    Route::get('/', [BuildingController::class, 'index']);
    Route::get('/{building}', [BuildingController::class, 'show']);
});
