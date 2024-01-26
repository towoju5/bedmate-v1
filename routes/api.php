<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\Escorts;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoriesController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserMetaController;
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


Route::any('compare', [MiscController::class, 'compare']);

Route::group([], function() {
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('verify-email', [AuthController::class, 'verify_email']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
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
            Route::put('become-kink', [Escorts::class, 'becomeAkinks']);
            Route::get('{customer_id}', [Escorts::class, 'kink']);
            Route::delete('{customer_id}', [Escorts::class, 'destroy']);
            
            // packages
            Route::post('{escortId}/packages',              [Escorts::class, 'addPackage']);
            Route::put('{escortId}/packages/{packageId}',   [Escorts::class, 'updatePackage']);
            Route::delete('{escortId}/packages/{packageId}', [Escorts::class, 'deletePackage']);
        });

        Route::group(['prefix' => 'gallery'], function() {
            Route::get('/',             [GalleryController::class, 'index']);
            Route::get('{media_id}',    [GalleryController::class, 'show']);
            Route::post('save',         [GalleryController::class, 'store']);
            Route::delete('{media_id}', [GalleryController::class, 'destroy']);
        });

        Route::group(['prefix' => 'stories'], function() {
            Route::get('/',                 [StoriesController::class, 'index']);
            Route::get('{media_id}',   [StoriesController::class, 'show']);
            Route::post('save',             [StoriesController::class, 'store']);
            Route::delete('{media_id}',     [StoriesController::class, 'destroy']);
        });

        Route::group(['prefix' => 'review'], function() {
            Route::get('{user_id}',         	[ReviewController::class, 'index']);
            Route::get('show/{review_id}',      [ReviewController::class, 'show']);
            Route::post('store/{userId}',   	[ReviewController::class, 'store']);
            Route::put('update/{review_id}',	[ReviewController::class, 'update']);
            Route::delete('{review_id}',    	[ReviewController::class, 'destroy']);
        });

        Route::group(['prefix' => 'connections'], function() {
            Route::post('/',            [ConnectionController::class, 'createConnection']);
            Route::patch('{id}/accept', [ConnectionController::class, 'acceptConnection']);
            Route::patch('{id}/reject', [ConnectionController::class, 'rejectConnection']);
            Route::patch('{id}/pay',    [ConnectionController::class, 'payForConnection']);
            Route::get('count',         [ConnectionController::class, 'getConnectionGroupCount']);
        });

        Route::group(['prefix' => 'token'], function() {
            Route::post('send',     [TokenController::class, 'send']);
            Route::post('verify',   [TokenController::class, 'verify']);
        });


        Route::group(['prefix' => 'user'], function() {
            Route::put('profile-image',     	[AuthController::class, 'updateProfileImage']);
            Route::get('username/{username}',   [AuthController::class, 'usernameCheck']);
            Route::group(['prefix' => 'meta-data'], function() {
                Route::post('/',                [UserMetaController::class, 'index']);
                Route::post('get',              [UserMetaController::class, 'show']);
                Route::post('add',              [UserMetaController::class, 'store']);
                Route::put('update/{key}',      [UserMetaController::class, 'update']);
                Route::delete('delete/{key}',   [UserMetaController::class, 'destroy']);
            });
        });

    });

    Route::post('verify-images', [MiscController::class, 'verifyImages']);
});

Route::post('no-login', function() {
	return get_error_response(['error' => "Unathenticated request"], 401);
})->name('login');

Route::fallback(function(){
    try {
        return get_error_response(['error' => "Page not found"]);
    } catch (\Throwable $th) {
        return get_error_response(['error' => $th->getMessage()]);
    }
});