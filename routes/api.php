<?php

use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;


// Public routes
Route::apiResource('restaurants', RestaurantController::class)
    ->only(['index', 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('restaurants', RestaurantController::class)
        ->except(['index', 'show']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	logger($request->user()->name);
    return response()->json($request->user());
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);