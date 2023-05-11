<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'user',
    'as'     => 'user',
], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group([
    'middleware' => 'auth:sanctum'
], function () {

    Route::group([
        'prefix' => 'currency',
        'as'     => 'currency',
    ], function () {
        Route::get('/{date}', [CurrencyController::class, 'index']);
        Route::get('/{date}/{currency}', [CurrencyController::class, 'show']);
    });

    Route::group([
        'prefix' => 'currency',
        'as'     => 'currency',
    ], function () {
        Route::post('', [CurrencyController::class, 'store']);
    });

    Route::group([
        'prefix' => 'user',
        'as'     => 'user',
    ], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
