<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\Escorts;
use App\Http\Controllers\GalleryController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'web'], function() {
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('verify-email', [AuthController::class, 'verify_email']);
    Route::post('resend-verification-email', [AuthController::class, 'resend_verification_email']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        // verify customer transactio PIN
        Route::post('pin/verify', [AuthController::class, 'transaction_pin']);
        Route::put('pin/update', [AuthController::class, 'transaction_pin']);

        Route::group(['prefix' => 'profile'], function() {
            Route::get('/', [AuthController::class, 'profile']);
            Route::put('update', [AuthController::class, 'update']);
        });

        Route::group(['prefix' => 'kinks'], function() {
            Route::get('/', [Escorts::class, 'kinks']);
            Route::post('{customer-id}', [Escorts::class, 'kink']);
            Route::delete('{customer-id}', [Escorts::class, 'destroy']);
        });

        Route::group(['prefix' => 'gallery'], function() {
            Route::get('/',             [GalleryController::class, 'index']);
            Route::get('{media-id}',    [GalleryController::class, 'show']);
            Route::post('save',         [GalleryController::class, 'store']);
            Route::delete('{media-id}', [GalleryController::class, 'destroy']);
        });
    });
});