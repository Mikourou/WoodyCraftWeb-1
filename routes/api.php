<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StatController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::put('/orders/{id}/expedier', [OrderController::class, 'expedierOrder']);
Route::put('/orders/{id}/validate', [OrderController::class, 'validateOrder']);

Route::apiResource('puzzles', PuzzleController::class);
Route::apiResource('logins', LoginController::class);
Route::post('/authentificate', [AuthController::class, 'authenticate']);
Route::apiResource('orders', OrderController::class);

Route::get('/stats', [StatController::class, 'stats']);
